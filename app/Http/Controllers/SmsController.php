<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Input;
use App\Mesabot;
use App\Sms;
use App\SmsGagal;
use App\Pasien;
use App\Config;
use App\Classes\Yoga;
use App\SmsKontak;
use App\Staf;
use DB;
use twilio\rest\client;
use twilio\exceptions\twilioexception;
class SmsController extends Controller
{

	public function sms(){
		//return env('TWILLIO_NUMBER');
		return view('sms.index', compact(''));
	}
	public function smsPost(){
		$rules = [
			'nomor' => 'required',
			'pesan' => 'required'
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Sms::send( Input::get('nomor'), Input::get('pesan'));

		$pesan = Yoga::suksesFlash('Pengiriman pesan ke nomor ' . Input::get('nomor'). ' berhasil');
		return redirect()->back()->withPesan($pesan);
	}
	public function smsBpjs($id){
		Sms::smsBpjs(Pasien::find($id), 'okelah kalau begitu');
	}
	public function angkakontak(){

		$tanggal = date('Y-m');
		$jumlah_peserta_bpjs = Config::where('config_variable', 'jumlah_peserta_bpjs')->first()->value;
		$angka_kontak_saat_ini = SmsKontak::angkaKontak($tanggal);
		// Kita asumsikan bahwa tanggal 1 itu belum bisa dihitung, jadi kita anggap tanggal 1 = tanggal 0, maka tanggal sekarang dikurangi 1
		$date = date('d') -1;

		// target angka kontak bulan ini adalah 31% dari jumlah peserta bpjs kita
		$target_bulan_ini = ceil( 31 / 100 * $jumlah_peserta_bpjs );
		// diharapkan target tersebut dipenuhi pada tanggal 26 setiap bulannya

		if ( $date > 27 ) {
			 $date = 27;
		}

		// Target yang harus kita capai hari ini adalah ( tanggal -1  ) / 27 hari target angka kontak tercapai
		$target_hari_ini = ceil( $target_bulan_ini * $date / 27 ) ;
		// Target berapa sms yang harus kita kirim hari ini adalah 
		// target berapa angka kontak hari ini dikurangi pencapaian angka kontak yang sudah kita capai hari sebelumnya
		// hasilnya adalah jumlah nomor yang harus kita sms hari ini
		$angka_kontak_kurang =  $target_hari_ini - $angka_kontak_saat_ini;
		// Jika angka kontak sudah tercapai sepenuhnya, maka kirim sebanyak 0 sms hari ini (jangan kirim sms)
		// Jika sekarang masih tanggal 1, jangan kirim sms, tunggu besok
		$angka_kontak_kurang = ( $angka_kontak_kurang > 0 ) ? $angka_kontak_kurang : 0;


		// Untuk menghitung berapa pasien yang harus kita kirim sms hari ini
		// ===================================================================
		//
		// kita hitung dulu jumlah pasien yang punya nomor asuransi bpjs
		// yang memiliki no_telp untuk kita kirim sms
		// yang termsuk pengantar yang sudah di masukkan pcare_submit
		// yang termsuk  sms_kontaks yang sudah di sms yang dimasukkan di pcare_submit
		// yang termsuk  pasien bpjs yang mengunakan Pembayaran non bpjs
		// yang termsuk  pasien bpjs yang mengunakan Pembayaran bpjs

		// Untuk menghitung berapa pasien yang harus kita kirim sms hari ini
		// ===================================================================
		$query = "SELECT id, replace( no_telp, ' ', '' ) as no_telp FROM pasiens ";
		// kita hitung dulu jumlah pasien yang punya nomor asuransi bpjs
		$query.= "WHERE nomor_asuransi_bpjs is not null ";
		// dikurangi pasien yang sudah masuk sebagai daftar pengantar yang sudah masuk di pcare
		$query.= "AND id not in( Select pengantar_id from pengantar_pasiens where created_at like '{$tanggal}%' and pcare_submit = 1 ) ";
		// dikurangi pasien yang memiliki nomor telepon sudah masuk sebagai daftar pengantar yang sudah kita BERHASIL sms
		$query.= "AND no_telp not in( Select ps.no_telp from sms_kontaks as sk join pasiens as ps on ps.id = sk.pasien_id where sk.created_at like '{$tanggal}%' ) ";
		// dikurangi pasien yang memiliki nomor telepon sudah masuk sebagai daftar pengantar yang sudah kita GAGAL sms
		$query.= "AND no_telp not in( Select ps.no_telp from sms_gagals as sk join pasiens as ps on ps.id = sk.pasien_id where sk.created_at like '{$tanggal}%' ) ";
		// dikurangi pasien BPJS yang berobat sebagai pembayaran non BPJS yang berhasil kita masukkan di pcare
		$query.= "AND id not in( Select px.pasien_id from kunjungan_sakits as ks join periksas as px on px.id = ks.periksa_id where ks.created_at like '{$tanggal}%' and ks.pcare_submit = 1 ) ";
		// dikurangi pasien BPJS yang berobat sebagai pembayaran BPJS yang berhasil kita masukkan di pcare
		$query.= "AND id not in( Select pasien_id from periksas where asuransi_id = 32 and created_at like '{$tanggal}%' ) ";
		// pilih pasien yang memiliki no_telp dengan awalan 08 atau +62 
		$query.= "AND ( no_telp like '08%' or no_telp like '+628%' ) ";
		// kita order by menurut no_telp, jangan sampai no_telp yang sama di sms 2 kali
		 $query.= "ORDER BY replace( no_telp, ' ', '' ) ";
		// kita batasi sesuai target angka kontak hari ini supaya gak terlalu banyak yang disms dan memudahkan penginputan
		$query.= "LIMIT {$angka_kontak_kurang} ";


		$sms = DB::select($query);
		// kita akan buat array dimana satu array memiliki element string no_telp dan element array id, 
		// dimana satu nomor telepon memungkinkan memiliki lebih dari 1 id, 
		// jadi satu sms, bisa masuk ke 2 atau lebih inputa pcare
		
		$dataSms = [];
		foreach ($sms as $s) {
			$sama = false;
			foreach ($dataSms as $k => $sm) {
				if ($sm['no_telp'] == $s->no_telp) {
					$dataSms[$k]['id'][] = $s->id;
					$sama = true;
				}
			}
			if (!$sama) {
				$dataSms[] = [
					'id' => [$s->id],
					'no_telp' => $s->no_telp
				];
			}
		}

		//masukkan sms pak yoga untuk kontrol sebagai sms terakhir yang masuk
		$dataSms = [
			'id' => ['151013024'],
			'no_telp' => '081381912803'
		];

		// pesan apa yang mau kita sms ada di dalam tabel configs , 
		$pesan = Config::where('config_variable', 'sms_blast_angka_kontak_bpjs')->first()->value;
		$timestamp = date('Y-m-d H:i:s');
		$data = [];
		$gagal = [];
		foreach ($dataSms as $value) {
			try {


				
				// Kita sms ke nomor satu per satu di looping sesuai query yang sudah kita buat
				//Sms::send( str_replace(' ','', $value->no_telp ), $pesan);
				// Jika berhasil masukkan array data;
				// Karena satu nomor telepon bisa memiliki lebih dari satu pemilik, 
				// maka masukkan semua pasien_id yang memiliki nomor telepon tersebut
				\Log::info('pengiriman ke ' . $value->no_telp . ' BERHASIL dilakukan pada ' . date('d-m-Y H:i:s'));
				foreach ($value['id'] as $val) {
					$data[] = [ 
						'pasien_id'  => $val,
						'pesan'      => $pesan,
						'created_at' => $timestamp,
						'updated_at' => $timestamp
					];
				}
			} catch (\Exception $e) {
				\Log::info('pengiriman ke ' . $value->no_telp . ' GAGAL dilakukan pada ' . date('d-m-Y H:i:s'));
				// Jika gagal masukkan array gagal;
				//
				foreach ($value['id'] as $val) {
					$gagal[] = [
						'pasien_id'  => $val,
						'pesan'      => $pesan,
						'error'      => $e->getMessage(),
						'created_at' => $timestamp,
						'updated_at' => $timestamp
					];
				}
			}
		}
		// masukkan semua yang berhasil (array data) ke tabel sms_kontaks
		SmsKontak::insert($data);
		// masukkan semua yang gagal (array gagal) ke tabel sms_gagals
		SmsGagal::insert($gagal);
	}

	public function smsSingle( $number, $message ){
		try {
			// 1 phone number
			$data = [
				'destination' => $number,
				'text' => $message
			];

			// boradcast

			$mesabot = new Mesabot;
			$mesabot->sms($data);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function smsBroadcast( $number_array, $message ){
		try {
			// boradcast
			$data = [
				'destination' => $number_array,
				'text' => $message
			];

			$mesabot = new Mesabot;
			$mesabot->sms($data);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	
	
	public function laporan(){

		$tanggall = Input::get('bulanTahun');
		$tanggal  = Yoga::blnPrep($tanggall);
		$sms_kontak = SmsKontak::where('created_at', $tanggal . '%')
								->where('pcare_submit', '0')
								->get();
		$sms_masuk = SmsKontak::where('created_at', $tanggal . '%')
								->where('pcare_submit', '1')
								->get();
		$sms_kontak = SmsGagal::where('created_at', $tanggal . '%')->get();
		return view('sms/laporan', compact(
			'sms_kontak', 
			'sms_gagal', 
			'sms_masuk'
		));
	}

	public function kontakulangi($id){

		$smskontak = SmsKontak::find($id);
		$nama = $smskontak->pasien->nama;
		$id = $smskontak->pasien_id;

		$confirm = $smskontak->delete();

		if ($confirm) {
			$pesan = Yoga::suksesFlash('Pasien bernama ' . $id . ' - ' . $nama . ' Berhasil masuk kembali ke list pengiriman');
		} else {
			$pesan = Yoga::gagalFlash('Pasien bernama ' . $id . ' - ' . $nama . ' Gagal masuk kembali ke list pengiriman');
		}

		return redirect()->back()->withPesan($pesan);
	}

	public function kontakgagal($id){
		$smskontak = SmsKontak::find($id);
		$smskontak->pcare_submit = '2';
		$confirm = $smskontak->save();
		if ($confirm) {
			$pesan = Yoga::suksesFlash('Pasien bernama ' . $id . ' - ' . $nama . ' Gagal diinput di pcare');
		} else {
			$pesan = Yoga::gagalFlash('Pasien bernama ' . $id . ' - ' . $nama . ' Gagal diinput di pcare');
		}
		return redirect()->back()->withPesan($pesan);
	}

	public function kontakpcare_submit($id){
		$smskontak = SmsKontak::find($id);
		$smskontak->pcare_submit = '1';
		$confirm = $smskontak->save();
		if ($confirm) {
			$pesan = Yoga::suksesFlash('Pasien bernama ' . $id . ' - ' . $nama . ' Gagal diinput di pcare');
		} else {
			$pesan = Yoga::gagalFlash('Pasien bernama ' . $id . ' - ' . $nama . ' Gagal diinput di pcare');
		}
		return redirect()->back()->withPesan($pesan);
	}
	public function smsKontakPost(){
		//return dd( Input::all() );
		//return Input::get('pcare_submit');
		$rules = [
		  "id" => "required",
		  "pcare_submit" => "required"
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		$sms               = SmsKontak::find( Input::get('id') );
		$sms->pcare_submit = Input::get('pcare_submit');
		$confirm = $sms->save();

		if ($confirm) {
			$pesan = Yoga::suksesFlash('SMS SUDAH di submit di pcare ');
		} else {
			$pesan = Yoga::gagalFlash('SMS BELUM di submit di pcare');
		}
		return redirect()->back()->withPesan($pesan);
	}
	public function smsGagalPost(){
		$rules = [
		  "id" => "required",
		  "pcare_submit" => "required"
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		$sms               = SmsGagal::find( Input::get('id') );
		$sms->pcare_submit = Input::get('pcare_submit');
		$confirm = $sms->save();

		if ($confirm) {
			$pesan = Yoga::suksesFlash('SMS SUDAH di submit di pcare ');
		} else {
			$pesan = Yoga::gagalFlash('SMS BELUM di submit di pcare');
		}
		return redirect()->back()->withPesan($pesan);
	}
	public function smsMasukPost(){
		$rules = [
		  "id" => "required",
		  "pcare_submit" => "required"
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		$sms               = SmsKontak::find( Input::get('id') );
		$sms->pcare_submit = Input::get('pcare_submit');
		$confirm = $sms->save();

		if ($confirm) {
			$pesan = Yoga::suksesFlash('SMS SUDAH di submit di pcare ');
		} else {
			$pesan = Yoga::gagalFlash('SMS BELUM di submit di pcare');
		}
		return redirect()->back()->withPesan($pesan);
	}
	
	
}



    
