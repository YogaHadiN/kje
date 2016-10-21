<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Pasien;
use Input;
use DB;
use App\AntrianPeriksa;
use App\AntrianPoli;
use App\PengantarPasien;
use App\Periksa;
use App\Classes\Yoga;

class PengantarsController extends Controller
{
    //
	public function antrianperiksasEdit($id){
		
		$ps = new Pasien;
		$statusPernikahan = $ps->statusPernikahan();
		$panggilan = $ps->panggilan();
		$asuransi = Yoga::asuransiList();
		$jenis_peserta = $ps->jenisPeserta();
		$staf = Yoga::stafList();
		$poli = Yoga::poliList();
		$ap = AntrianPeriksa::find($id);

		$pengantars = [];


		foreach ($ap->antars as $v) {
			$pengantars[] =  $this->pengantarArray($v);
		}

		$pengantars = json_encode($pengantars);
		return view('antrianperiksas.pengantar_edit', compact(
			'ap',
			'panggilan',
			'pengantars',
			'statusPernikahan',
			'asuransi',
			'jenis_peserta',
			'staf',
			'poli'
		));
	}
	public function antrianperiksasUpdate(){
		$rules = [
			'antrian_periksa_id' => 'required'
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		PengantarPasien::where('antarable_type', 'App\AntrianPeriksa')
			->where('antarable_id', Input::get('antrian_periksa_id') )
			->delete();

		$insert =  $this->insertArrayPengantar( 
			Input::all(), 
			Input::file('kartu_bpjs'), 
			Input::hasFile('kartu_bpjs'), 
			Input::file('ktp'), 
			Input::hasFile('ktp'), 
			'App\AntrianPeriksa',
			'antrian_periksa_id'
		); 
		if(!$insert){
			return redirect('antrianperiksas')->withPesan(Yoga::gagalFlash('Tidak ada pengantar yang ditambahkan'));
		}
		$ap = AntrianPeriksa::find( Input::get('antrian_periksa_id') );
		$pesan = 'Pengantar Berhasil Ditambahkan, total ada <strong>' . $insert . ' pengantar</strong> yang terdaftar untuk ' . $ap->pasien->nama;
		return redirect('ruangperiksa/' . $ap->poli)->withPesan( Yoga::suksesFlash($pesan) );
	}

	public function pengantarPost(){
		$rules = [
			'antrian_poli_id' => 'required'
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$insert =  $this->insertArrayPengantar( 
			Input::all(), 
			Input::file('kartu_bpjs'), 
			Input::hasFile('kartu_bpjs'), 
			Input::file('ktp'), 
			Input::hasFile('ktp'), 
			'App\AntrianPoli',
			'antrian_poli_id'
		); 
		if(!$insert){
			return redirect('antrianpolis')->withPesan(Yoga::gagalFlash('Tidak ada pengantar yang ditambahkan'));
		}
		$pesan = 'Pengantar Berhasil Ditambahkan, total ada <strong>' . $insert . ' pengantar</strong> yang terdaftar untuk ' . AntrianPoli::find( Input::get('antrian_poli_id') )->pasien->nama;
		return redirect('antrianpolis')->withPesan( Yoga::suksesFlash($pesan) );
	}
	
	public function createPasien(){
		
		$ps = new Pasien;
		$statusPernikahan = $ps->statusPernikahan();
		$panggilan = $ps->panggilan();
		$asuransi = Yoga::asuransiList();
		$jenis_peserta = $ps->jenisPeserta();
		$staf = Yoga::stafList();
		$poli = Yoga::poliList();
		
		return view('antrianpolis.createPasien')
			->withAsuransi($asuransi)
			->with('statusPernikahan', $statusPernikahan)
			->with('panggilan', $panggilan)
			->withJenis_peserta($jenis_peserta)
			->withStaf($staf)
			->withPoli($poli);
	}


	public function storePasien(){

		$rules = [
			"nama" => "required",
			"sex" => "required",
			"panggilan" => "required"
		];

		if ( Input::get('punya_asuransi') == '1' ) {
			  $rules["asuransi_id"] = "required";
			  $rules["jenis_peserta"] = "required";
			  $rules["nomor_asuransi"] = "required";
		}
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		if (empty(trim(Input::get('asuransi_id')))) {
			$asuransi_id = 0;
		} else {
			$asuransi_id = Input::get('asuransi_id');
		}

		$id = Yoga::customId('App\Pasien');

		$pasien                 = new Pasien;
		$pasien->alamat         = Input::get('alamat');
		$pasien->asuransi_id    = $asuransi_id;
		$pasien->sex            = Input::get('sex');
		$pasien->jenis_peserta  = Input::get('jenis_peserta');
		$pasien->nama_ayah      = ucwords(strtolower(Input::get('nama_ayah')));
		$pasien->nama_ibu       = ucwords(strtolower(Input::get('nama_ibu')));
		$pasien->nama           = ucwords(strtolower(Input::get('nama')))  . ', ' . Input::get('panggilan');
		$pasien->nama_peserta   = ucwords(strtolower(Input::get('nama_peserta')));
		$pasien->nomor_asuransi = Input::get('nomor_asuransi');
		$pasien->no_telp        = Input::get('no_telp');
		$pasien->tanggal_lahir  = Yoga::datePrep(Input::get('tanggal_lahir'));
		$pasien->id             = $id;
		$pasien->bpjs_image     = $pasien->imageUpload('bpjs','bpjs_image', $id);
		$pasien->ktp_image      = $pasien->imageUpload('ktp', 'ktp_image', $id);
		$pasien->image          = Yoga::inputImageIfNotEmpty(Input::get('image'), $id);
		$conf = $pasien->save();
	
		if ($conf) {
			$pesan = Yoga::suksesFlash( '<strong>' . $id . ' - ' . $pasien->nama . '</strong> Berhasil dibuat dan berhasil masuk antrian Nurse Station' );
		} else {
			$pesan = Yoga::suksesFlash( '<strong>' . $id . ' - ' . $pasien->nama . '</strong> Gagal masuk antrian Nurse Station' );
		}

		return redirect()->back()
			->withPesan($pesan);
	}

	public function pengantar($id){


		$ps = new Pasien;
		$statusPernikahan = $ps->statusPernikahan();
		$panggilan = $ps->panggilan();
		$asuransi = Yoga::asuransiList();
		$jenis_peserta = $ps->jenisPeserta();
		$staf = Yoga::stafList();
		$poli = Yoga::poliList();
		$ap = AntrianPoli::with('pasien','asuransi','staf')->where('id', $id)->first();
		return view('antrianpolis.pengantar', compact(
			'ap',
			'panggilan',
			'statusPernikahan',
			'asuransi',
			'jenis_peserta',
			'staf',
			'poli'
		));
	}

	public function pengantarEdit($id){

		$ps = new Pasien;
		$statusPernikahan = $ps->statusPernikahan();
		$panggilan = $ps->panggilan();
		$asuransi = Yoga::asuransiList();
		$jenis_peserta = $ps->jenisPeserta();
		$staf = Yoga::stafList();
		$poli = Yoga::poliList();
		$ap = AntrianPoli::find($id);

		$pengantars = [];


		foreach ($ap->antars as $v) {
			$pengantars[] =  $this->pengantarArray($v);
		}

		$pengantars = json_encode($pengantars);


		return view('antrianpolis.pengantar_edit', compact(
			'ap',
			'panggilan',
			'pengantars',
			'statusPernikahan',
			'asuransi',
			'jenis_peserta',
			'staf',
			'poli'
		));
	}
	

	public function kartubpjs(){

		$pasien_id = Input::get('pasien_id');
		$pasien = Pasien::find($pasien_id);
		$date = date('Y-m'). '%';
		$sudah = Periksa::where('tanggal', 'like', $date)->where('pasien_id', $pasien_id)->count();
		$query = "SELECT count(pp.id) as count FROM pengantar_pasiens as pp join periksas as px on px.id = pp.antarable_id WHERE antarable_type='App\\\Periksa' and pp.pengantar_id = '{$pasien_id}' and tanggal like '{$date}'";
		$iniPengantar = DB::select($query);
		$adaPengantar = $iniPengantar[0]->count;
		$sudah = $sudah + $adaPengantar;
		if ($sudah > 0) {
			$confirmSudah = '1';
		} else {
			$confirmSudah = '0';
		}
		return json_encode( [
			'bpjs_image' => $pasien->bpjs_image,
			'ktp_image' => $pasien->ktp_image,
			'asuransi_id' => $pasien->asuransi_id,
			'nomor_asuransi' => $pasien->nomor_asuransi,
			'confirmSudah' => $confirmSudah
		] );
	}

	public function pengantarUpdate($id){

		$rules = [
			'antrian_poli_id' => 'required'
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{ return \Redirect::back()->withErrors($validator)->withInput(); }

		PengantarPasien::where('antarable_type', 'App\AntrianPoli')->where('antarable_id', $id)->delete();
		$insert =  $this->insertArrayPengantar( 
			Input::all(), 
			Input::file('kartu_bpjs'), 
			Input::hasFile('kartu_bpjs'), 
			Input::file('ktp'), 
			Input::hasFile('ktp'), 
			'App\AntrianPoli',
			'antrian_poli_id'
		); 
		if(!$insert){
			return redirect('antrianpolis')->withPesan(Yoga::gagalFlash('Tidak ada pengantar yang ditambahkan'));
		}

		$pesan = 'Pengantar Berhasil Diedit, total ada <strong>' . $insert . ' pengantar</strong> yang terdaftar untuk ' . AntrianPoli::find( Input::get('antrian_poli_id') )->pasien->nama;
		return redirect('antrianpolis')->withPesan( Yoga::suksesFlash($pesan) );
	}

	private function imageUpload($pre, $hasFile, $inputName, $id){
		if( $hasFile ) {

			$upload_cover = $inputName;
			//mengambil extension
			$extension = $upload_cover->getClientOriginalExtension();

			//membuat nama file random + extension
			$filename =	 $pre . $id . '.' . $extension;

			//menyimpan bpjs_image ke folder public/img
			$destination_path = public_path() . DIRECTORY_SEPARATOR . 'img/pasien';

			// Mengambil file yang di upload
			$upload_cover->move($destination_path, $filename);
			
			//mengisi field bpjs_image di book dengan filename yang baru dibuat
			return 'img/pasien/'. $filename;
			
		} else {
			return null;
		}

		 
	}
	private function insertArrayPengantar($all, $file_kartu_bpjs, $has_kartu_bpjs, $file_ktp, $has_ktp, $model, $id){
		
		$json = $all['jsonArray'];
		$antrian_poli_id = $all[$id];
		if ( $json != '' && $json != '[]' ) {
			$json = json_decode( $json, true );
			$dataArray = [];
			foreach ($json as $j) {
				$dataArray[] = [
					'antarable_id' => $antrian_poli_id,
					'antarable_type' =>$model,
					'pengantar_id' => $j['id'],
					'kunjungan_sehat' => $j['kunjungan_sehat'],
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				];
			}
			$confirm = PengantarPasien::insert($dataArray);
			if ($confirm) {
				$count = count($json);
			}
			$BPJSnull = [];
			$KTPnull = [];
			foreach ($json as $js) {
				if ($js['kartu_bpjs'] == '' || $js['kartu_bpjs'] == null ||  $js['kartu_bpjs'] == 'null') {
					$BPJSnull[] = $js;
				}
				if ($js['ktp'] == '' || $js['ktp'] == null || $js['ktp'] == 'null') {
					$KTPnull[] = $js;
				}
			}
			foreach ($BPJSnull as $k => $bpjs) {
				if (isset(  $file_kartu_bpjs[$k]  )) {
					$pasien       = Pasien::find($bpjs['id']);
					$pasien->bpjs_image   = $this->imageUpload('bpjs', $has_kartu_bpjs,  $file_kartu_bpjs[$k], $bpjs['id']);
					$pasien->save();
				}
			}
			foreach ($KTPnull as $k => $ktp) {
				if (isset(  $file_ktp[$k]  )) {
					$pasien       = Pasien::find($ktp['id']);
					$pasien->ktp_image   = $this->imageUpload('ktp', $has_ktp,  $file_ktp[$k], $ktp['id']);
					$pasien->save();
				}
			}
			return $count;
		} else {
			return false;
		}
		 
	}
	public function antriankasirsEdit($id){
		
		$ps = new Pasien;
		$statusPernikahan = $ps->statusPernikahan();
		$panggilan = $ps->panggilan();
		$asuransi = Yoga::asuransiList();
		$jenis_peserta = $ps->jenisPeserta();
		$staf = Yoga::stafList();
		$poli = Yoga::poliList();
		$ap = Periksa::find($id);

		$pengantars = [];

		foreach ($ap->antars as $v) {
			$pengantars[] =  $this->pengantarArray( $v );
		}

		$pengantars = json_encode($pengantars);
		return view('antriankasirs.pengantar_edit', compact(
			'ap',
			'panggilan',
			'pengantars',
			'statusPernikahan',
			'asuransi',
			'jenis_peserta',
			'staf',
			'poli'
		));

	}
	public function antriankasirsUpdate($id){
		$rules = [
			'periksa_id' => 'required'
		];
		$validator = \Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{ return \Redirect::back()->withErrors($validator)->withInput(); }
		PengantarPasien::where('antarable_type', 'App\Periksa')->where('antarable_id', $id)->delete();
		$insert =  $this->insertArrayPengantar( 
			Input::all(), 
			Input::file('kartu_bpjs'), 
			Input::hasFile('kartu_bpjs'), 
			Input::file('ktp'), 
			Input::hasFile('ktp'), 
			'App\Periksa',
			'periksa_id'
		); 
		if(!$insert){
			return redirect('antriankasirs')->withPesan(Yoga::gagalFlash('Tidak ada pengantar yang ditambahkan'));
		}
		$pesan = 'Pengantar Berhasil Diedit, total ada <strong>' . $insert . ' pengantar</strong> yang terdaftar untuk ' . Periksa::find( Input::get('periksa_id') )->pasien->nama;
		return redirect('antriankasirs')->withPesan( Yoga::suksesFlash($pesan) );
	}
	private function pengantarArray($v){
		 
			return [
				'id' => $v->pengantar->id ,
				'nama' => $v->pengantar->nama ,
				'kartu_bpjs' => $v->pengantar->bpjs_image,
				'ktp' => $v->pengantar->ktp_image,
				'kunjungan_sehat' => $v->kunjungan_sehat
			];	

			
	}
}
