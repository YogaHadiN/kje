<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Input;
use Log;
use DB;
use Storage;
use App\Models\Pasien;
use App\Models\VerifikasiProlanis;
use App\Models\AntrianPeriksa;
use App\Models\AntrianPoli;
use App\Models\SmsJangan;
use App\Models\PengantarPasien;
use App\Models\KunjunganSakit;
use App\Models\Periksa;
use App\Models\Classes\Yoga;

class PengantarsController extends Controller
{
    //
	public function antrianperiksasEdit($id){
		
		$ps               = new Pasien;
		$statusPernikahan = $ps->statusPernikahan();
		$panggilan        = $ps->panggilan();
		$asuransi         = Yoga::asuransiList();
		$jenis_peserta    = $ps->jenisPeserta();
		$staf             = Yoga::stafList();
		$poli             = Yoga::poliList();
		$ap               = AntrianPeriksa::find($id);
		$peserta          = [ null => '- Pilih -', '0' => 'Peserta Klinik', '1' => 'Bukan Peserta Klinik'];
		$pengantars       = [];


		foreach ($ap->antars as $v) {
			$pengantars[] =  $this->pengantarArray($v);
		}

		$riwayat = $this->riwayatPengantaran($ap);

		$pengantars = json_encode($pengantars);
		return view('antrianperiksas.pengantar_edit', compact(
			'ap',
			'panggilan',
			'riwayat',
			'pengantars',
			'peserta',
			'statusPernikahan',
			'asuransi',
			'jenis_peserta',
			'staf',
			'poli'
		));
	}


	public function update(){
		dd(Input::all()); 
		$rules = [
			'antrian_periksa_id' => 'required'
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		PengantarPasien::where('antarable_type', 'App\Models\AntrianPeriksa')
			->where('antarable_id', Input::get('antrian_periksa_id') )
			->delete();

		$insert =  $this->insertArrayPengantar( 
			Input::all(), 
			Input::file('kartu_bpjs'), 
			Input::hasFile('kartu_bpjs'), 
			Input::file('ktp'), 
			Input::hasFile('ktp'), 
			'App\Models\AntrianPeriksa',
			'antrian_periksa_id'
		); 
		if(!$insert){
			return redirect('antrianperiksas')->withPesan(Yoga::gagalFlash('Tidak ada pengantar yang ditambahkan'));
		}
		$ap                   = AntrianPeriksa::find( Input::get('antrian_periksa_id') );
		$pesan                = 'Pengantar Berhasil Ditambahkan, total ada <strong>' . $insert . ' pengantar</strong> yang terdaftar untuk ' . $ap->pasien->nama;
		$jenis_antrian_id     = '6';
		if (!is_null($ap->antrian)) {
			$jenis_antrian_id = $ap->antrian->jenis_antrian_id;
		}
		return redirect('ruangperiksa/' . $jenis_antrian_id)->withPesan( Yoga::suksesFlash($pesan) );
	}

	public function pengantarPost(){
		dd(Input::all());
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
			'App\Models\AntrianPoli',
			'antrian_poli_id'
		); 
		if(!$insert){
			return redirect('antrianpolis')->withPesan(Yoga::gagalFlash('Tidak ada pengantar yang ditambahkan'));
		}
		$pesan = 'Pengantar Berhasil Ditambahkan, total ada <strong>' . $insert . ' pengantar</strong> yang terdaftar untuk ' . AntrianPoli::find( Input::get('antrian_poli_id') )->pasien->nama;
		return redirect('antrianpolis')->withPesan( Yoga::suksesFlash($pesan) );
	}

	public function store($posisi_antrian, $id){
		$model = $this->getModel($posisi_antrian);
		$insert =  $this->insertArrayPengantar( 
			Input::all(), 
			Input::file('kartu_bpjs'), 
			Input::hasFile('kartu_bpjs'), 
			Input::file('ktp'), 
			Input::hasFile('ktp'), 
			$model,
			$id
		); 
		if(!$insert){
			return redirect($posisi_antrian)->withPesan(Yoga::gagalFlash('Tidak ada pengantar yang ditambahkan'));
		}
		if (is_null( $model::find($id) )) {
			$pesan = Yoga::gagalFlash('Antrian tidak ditemukan');
			Log::info('=================================');
			Log::info('antrian tidak ditemukan');
			Log::info($model);
			Log::info('=================================');
			return redirect()->back()->withPesan($pesan);
		}

		$nama = $this->getNama($model, $id, $posisi_antrian);
		$pesan = 'Pengantar Berhasil Ditambahkan, total ada <strong>' . $insert . ' pengantar</strong> yang terdaftar untuk ' . $nama;
		$redirect = $posisi_antrian;
		if ($posisi_antrian == 'antrianperiksas') {
			$antrianperiksa = AntrianPeriksa::find($id);
			$jenis_antrian_id = $antrianperiksa->ispoli->poli_antrian->jenis_antrian_id;
			$redirect = 'ruangperiksa/' . $jenis_antrian_id;
		}
		return redirect($redirect)->withPesan( Yoga::suksesFlash($pesan) );
	}
	
	public function createPasien(){
		
		$ps = new Pasien;
		$statusPernikahan = $ps->statusPernikahan();
		$panggilan = $ps->panggilan();
		$asuransi = Yoga::asuransiList();
		$jenis_peserta = $ps->jenisPeserta();
		$staf = Yoga::stafList();
		$poli = Yoga::poliList();
		$peserta = [ null => '- Pilih -', '0' => 'Peserta Klinik', '1' => 'Bukan Peserta Klinik'];
		return view('antrianpolis.createPasien')
			->withAsuransi($asuransi)
			->with('statusPernikahan', $statusPernikahan)
			->with('panggilan', $panggilan)
			->with('peserta', $peserta)
			->with('jenis_peserta', $jenis_peserta)
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

		$id = Yoga::customId('App\Models\Pasien');

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
		if ($asuransi_id == '32') {
			$pasien->nomor_asuransi_bpjs = Input::get('nomor_asuransi');
		}
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

	public function pengantar($posisi_antrian, $id){
		$ps               = new Pasien;
		$statusPernikahan = $ps->statusPernikahan();
		$panggilan        = $ps->panggilan();
		$asuransi         = Yoga::asuransiList();
		$jenis_peserta    = $ps->jenisPeserta();
		$staf             = Yoga::stafList();
		$poli             = Yoga::poliList();

		$model          = $this->getModel($posisi_antrian);
		$antrian_posisi = $model::find($id);
		if (is_null($antrian_posisi)) {
			$pesan = Yoga::gagalFlash('Antrian tidak ditemukan');
			return redirect()->back()->withPesan($pesan);
		}
		if ( $posisi_antrian == 'antrianperiksas' ||  $posisi_antrian == 'antrianpolis' ) {
			$ap             = $antrian_posisi;
		} else if ( $posisi_antrian == 'antrianapoteks' ||  $posisi_antrian == 'antriankasirs' ){
			$ap = $antrian_posisi->periksa;
		}
		$peserta          = [ null => '- Pilih -', '0' => 'Peserta Klinik', '1' => 'Bukan Peserta Klinik'];
		$riwayat          = $this->riwayatPengantaran($antrian_posisi);
		$pengantars       = [];
		if ( $antrian_posisi->antars->count() > 0 ) {
			foreach ($antrian_posisi->antars as $v) {
				$pengantars[] =  $this->pengantarArray($v);
			}
		}
		$pengantars = json_encode($pengantars);
		$riwayat    = $this->riwayatPengantaran($ap);
		$verifikasi_prolanis_options =  VerifikasiProlanis::pluck( 'verifikasi_prolanis', 'id');
		return view( 'antrianpolis.pengantar', compact(
			'ap',
			'id',
			'panggilan',
			'verifikasi_prolanis_options',
			'posisi_antrian',
			'pengantars',
			'riwayat',
			'peserta',
			'statusPernikahan',
			'asuransi',
			'jenis_peserta',
			'staf',
			'poli'
		));
	}

	public function pengantarEdit($id){

		$ps               = new Pasien;
		$statusPernikahan = $ps->statusPernikahan();
		$panggilan        = $ps->panggilan();
		$asuransi         = Yoga::asuransiList();
		$jenis_peserta    = $ps->jenisPeserta();
		$staf             = Yoga::stafList();
		$poli             = Yoga::poliList();
		$ap               = AntrianPoli::find($id);
		$peserta          = [ null => '- Pilih -', '0' => 'Peserta Klinik', '1' => 'Bukan Peserta Klinik'];

		$pengantars       = [];
		foreach ($ap->antars as $v) {
			$pengantars[] =  $this->pengantarArray($v);
		}
		$pengantars = json_encode($pengantars);

		$riwayat = $this->riwayatPengantaran($ap);

		return view('antrianpolis.pengantar_edit', compact(
			'ap',
			'panggilan',
			'riwayat',
			'pengantars',
			'statusPernikahan',
			'asuransi',
			'peserta',
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
		$query = "SELECT count(pp.id) as count ";
		$query .= "FROM pengantar_pasiens as pp ";
		$query .= "join periksas as px on px.id = pp.antarable_id ";
		$query .= "WHERE antarable_type='App\\\Models\\\Periksa' ";
		$query .= "AND pp.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and pp.pengantar_id = '{$pasien_id}' ";
		$query .= "and tanggal like '{$date}'";
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

		PengantarPasien::where('antarable_type', 'App\Models\AntrianPoli')->where('antarable_id', $id)->delete();
		$insert =  $this->insertArrayPengantar( 
			Input::all(), 
			Input::file('kartu_bpjs'), 
			Input::hasFile('kartu_bpjs'), 
			Input::file('ktp'), 
			Input::hasFile('ktp'), 
			'App\Models\AntrianPoli',
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
			$filename =	 $pre . $id . '_' . time() . '.' . $extension;

			//menyimpan bpjs_image ke folder public/img
			/* $destination_path = public_path() . DIRECTORY_SEPARATOR . 'img/pasien/'; */
			$destination_path = 'img/pasien/';

			// Mengambil file yang di upload
			/* $upload_cover->move($destination_path, $filename); */

			Storage::disk('s3')->put($destination_path. $filename, file_get_contents($upload_cover));
			//mengisi field bpjs_image di book dengan filename yang baru dibuat
			return 'img/pasien/'. $filename;
			
		} else {
			return null;
		}

		 
	}
	private function insertArrayPengantar($all, $file_kartu_bpjs, $has_kartu_bpjs, $file_ktp, $has_ktp, $model, $id){
		
		$json      = $all['jsonArray'];
		$posisi_id = $id;



		
		PengantarPasien::where('antarable_type',$model)
						->where('antarable_id',$posisi_id)
						->delete();

		if ( $json != '' && $json != '[]' ) {
			$json = json_decode( $json, true );
			$dataArray = [];
			foreach ($json as $j) {
				$dataArray[] = [
					'antarable_id'    => $posisi_id,
					'antarable_type'  => $model,
					'pengantar_id'    => $j['id'],
					'kunjungan_sehat' => $j['kunjungan_sehat'],
							'tenant_id'  => session()->get('tenant_id'),
					'created_at'      => date('Y-m-d H:i:s'),
					'updated_at'      => date('Y-m-d H:i:s')
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

	public function edit($posisi_antrian, $id){
		
		$ps               = new Pasien;
		$statusPernikahan = $ps->statusPernikahan();
		$panggilan        = $ps->panggilan();
		$asuransi         = Yoga::asuransiList();
		$jenis_peserta    = $ps->jenisPeserta();
		$staf             = Yoga::stafList();
		$poli             = Yoga::poliList();
		$ap               = Periksa::find($id);

		$peserta = [ null => '- Pilih -', '0' => 'Peserta Klinik', '1' => 'Bukan Peserta Klinik'];
		$pengantars = [];

		foreach ($ap->antars as $v) {
			$pengantars[] =  $this->pengantarArray( $v );
		}

		$pengantars = json_encode($pengantars);

		$riwayat = $this->riwayatPengantaran($ap);

		return view($posisi_antrian .'.pengantar_edit', compact(
			'ap',
			'posisi_antrian',
			'panggilan',
			'riwayat',
			'pengantars',
			'statusPernikahan',
			'asuransi',
			'jenis_peserta',
			'peserta',
			'staf',
			'poli'
		));

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

		$peserta = [ null => '- Pilih -', '0' => 'Peserta Klinik', '1' => 'Bukan Peserta Klinik'];
		$pengantars = [];

		foreach ($ap->antars as $v) {
			$pengantars[] =  $this->pengantarArray( $v );
		}

		$pengantars = json_encode($pengantars);

		$riwayat = $this->riwayatPengantaran($ap);

		return view('antriankasirs.pengantar_edit', compact(
			'ap',
			'panggilan',
			'riwayat',
			'pengantars',
			'statusPernikahan',
			'asuransi',
			'jenis_peserta',
			'peserta',
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
		PengantarPasien::where('antarable_type', 'App\Models\Periksa')->where('antarable_id', $id)->delete();

		$insert =  $this->insertArrayPengantar( 
			Input::all(), 
			Input::file('kartu_bpjs'), 
			Input::hasFile('kartu_bpjs'), 
			Input::file('ktp'), 
			Input::hasFile('ktp'), 
			'App\Models\Periksa',
			'periksa_id'
		); 
		if(!$insert){
			return redirect('antriankasirs')->withPesan(Yoga::gagalFlash('Tidak ada pengantar yang ditambahkan'));
		}
		$pesan = 'Pengantar Berhasil Diedit, total ada <strong>' . $insert . ' pengantar</strong> yang terdaftar untuk ' . Periksa::find( Input::get('periksa_id') )->pasien->nama;
		return redirect('antriankasirs')->withPesan( Yoga::suksesFlash($pesan) );
	}

	public function submitPcare(){
		$id                          = Input::get('id');
		$kunjungan_sehat             = Input::get('kunjungan_sehat');
		$pcare_submit                = Input::get('pcare_submit');
		$pp                          = Pasien::find($id);
		$pp->sudah_kontak_bulan_ini = 1;
		$pp->save();
		$confirm                     = PengantarPasien::where('pengantar_id', $id)
			->where('created_at', 'like' , date('Y-m') . '%')
			->update([
				'pcare_submit'    => $pcare_submit,
				'kunjungan_sehat' => $kunjungan_sehat
			]);
		if ($confirm) {
			$pesan = Yoga::suksesFlash('Pastikan anda sudah memasukkan pasien <strong>' . $pp->nama . '</strong> di PCare');
		} else {
			$pesan = Yoga::gagalFlash('Pengantar <strong>' . $pp->nama . '</strong> gagal dimasukkan dalam Pcare');
		}
		return redirect()->back()->withPesan($pesan);
	}
	
	private function pengantarArray($v){
		 
			return [
				'id' => $v->pengantar->id ,
				'nama' => $v->pengantar->nama ,
				'asuransi_id' => $v->pengantar->asuransi_id ,
				'nomor_asuransi' => $v->pengantar->nomor_asuransi_bpjs ,
				'kartu_bpjs' => $v->pengantar->bpjs_image,
				'ktp' => $v->pengantar->ktp_image,
				'kunjungan_sehat' => $v->kunjungan_sehat
			];	

			
	}

	public function storePasienAjax(){
		$pasien_id = Yoga::customId('App\Models\Pasien');
		$ps       = new Pasien;
		if (empty(trim(Input::get('asuransi_id')))) {
			$asuransi_id = 0;
		} else {
			$asuransi_id = Input::get('asuransi_id');
		}
		$ps->id   = $pasien_id;
		$ps->nama   = Input::get('nama') . ', '. Input::get('panggilan');
		$ps->alamat   = Input::get('alamat');
		$ps->tanggal_lahir   = Yoga::datePrep( Input::get('tanggal_lahir') );
		$ps->sex   = Input::get('sex');
		$ps->asuransi_id   = $asuransi_id;
		if ($asuransi_id == '32') {
			$ps->nomor_asuransi_bpjs = Input::get('nomor_asuransi');
		}
		$ps->nomor_asuransi   = Input::get('nomor_asuransi');
		$ps->jenis_peserta   = Input::get('jenis_peserta');
		$ps->nomor_asuransi   = Input::get('nomor_asuransi');
		$ps->nama_peserta   = Input::get('nama_peserta');
		$ps->no_telp   = Input::get('no_telp');
		$ps->nama_ayah   = Input::get('nama_ayah');
		$ps->nama_ibu   = Input::get('nama_ibu');
		$confirm = $ps->save();
		if ($confirm) {

			$data = [
				'pasien_id' => $pasien_id,
				'nama' => $ps->nama,
				'nomor_asuransi' => $ps->nomor_asuransi
			];
			
			return json_encode( [
				'confirm' => '1',
				'insert' => $data
			] );
		} else {
			return json_encode( ['confirm' => 0] );
		}
	}

	public function postKunjunganSakit(){
		$id                              = Input::get('id');
		$ks                              = KunjunganSakit::find($id);
		$ks->pcare_submit                = Input::get('pcare_submit');
		$confirm                         = $ks->save();
		$pasien                          = $ks->periksa->pasien;
		$pasien->sudah_kontak_bulan_ini = 1;
		$pasien->save();

		if ($confirm) {
			$pesan = Yoga::suksesFlash('Pastikan anda sudah memasukkan pasien <strong>' . $ks->periksa->pasien->nama . '</strong> di PCare');
		} else {
			$pesan = Yoga::gagalFlash('Pasien gagal dimasukkan');
		}

		return redirect()->back()->withPesan($pesan);
	}
	
	public function editPengantarPeriksa($id){

		$ps = new Pasien;
		$statusPernikahan = $ps->statusPernikahan();
		$panggilan = $ps->panggilan();
		$asuransi = Yoga::asuransiList();
		$jenis_peserta = $ps->jenisPeserta();
		$staf = Yoga::stafList();
		$poli = Yoga::poliList();
		$ap = Periksa::find($id);
		$peserta = [ null => '- Pilih -', '0' => 'Peserta Klinik', '1' => 'Bukan Peserta Klinik'];
		$pengantars = [];

		foreach ($ap->antars as $v) {
			$pengantars[] =  $this->pengantarArray($v);
		}

		$riwayat = $this->riwayatPengantaran($ap);

		$pengantars = json_encode($pengantars);
		return view('laporans.pengantar_edit', compact(
			'ap',
			'panggilan',
			'riwayat',
			'pengantars',
			'peserta',
			'statusPernikahan',
			'asuransi',
			'jenis_peserta',
			'staf',
			'poli'
		));
	}
	
	public function updatePengantarPeriksa($id){
		$rules = [
			'periksa_id' => 'required'
		];
		$validator = \Validator::make(Input::all(), $rules);
		if ($validator->fails())
		{ return \Redirect::back()->withErrors($validator)->withInput(); }
		PengantarPasien::where('antarable_type', 'App\Models\Periksa')->where('antarable_id', $id)->delete();
		$insert =  $this->insertArrayPengantar( 
			Input::all(), 
			Input::file('kartu_bpjs'), 
			Input::hasFile('kartu_bpjs'), 
			Input::file('ktp'), 
			Input::hasFile('ktp'), 
			'App\Models\Periksa',
			'periksa_id'
		); 
		if(!$insert){
			return redirect('antriankasirs')->withPesan(Yoga::gagalFlash('Tidak ada pengantar yang ditambahkan'));
		}
		$pesan = 'Pengantar Berhasil Diedit, total ada <strong>' . $insert . ' pengantar</strong> yang terdaftar untuk ' . Periksa::find( Input::get('periksa_id') )->pasien->nama;
		return redirect('antriankasirs')->withPesan( Yoga::suksesFlash($pesan) );
	}
	
	public function postServiceAc(){
		$rules = [
			'' => '',
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function riwayatPengantaran($ap)
	{
		$query  = "SELECT ";
		$query .= "pengantar_id, ";
		$query .= "pps.nama as nama_pengantar, ";
		$query .= "pps.tanggal_lahir, ";
		$query .= "prx.tanggal as tanggal_antar ";
		$query .= "FROM pengantar_pasiens as ppg ";
		$query .= "join periksas as prx on prx.id = antarable_id ";
		$query .= "JOIN pasiens as pas on pas.id = prx.pasien_id ";
		$query .= "join pasiens as pps on pps.id = ppg.pengantar_id ";
		$query .= "where pas.id = '{$ap->pasien_id}' ";
		$query .= "and antarable_type = 'App\\\Models\\\Periksa' ";
		$query .= "AND ppg.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "group by pengantar_id ";
		$query .= "order by prx.created_at; ";
		/* dd( $query ); */
		return DB::select($query);
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function getModel($posisi_antrian)
	{
		if ( $posisi_antrian == 'antrianperiksas') {
			$model = 'App\Models\AntrianPeriksa';
		} else if ( $posisi_antrian == 'antrianpolis' ){
			$model = 'App\Models\AntrianPoli';
		} else if ( $posisi_antrian == 'antrianapoteks' ){
			$model = 'App\Models\AntrianApotek';
		} else if ( $posisi_antrian == 'antriankasirs' ){
			$model = 'App\Models\AntrianKasir';
		}
		return $model;
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function getNama($model, $id, $posisi_antrian)
	{
		if ( $posisi_antrian == 'antrianperiksas' ||  $posisi_antrian == 'antrianpolis' ) {
			return $model::find($id)->pasien->nama;
		} else if ( $posisi_antrian == 'antrianapoteks' ||  $posisi_antrian == 'antriankasirs' ){
			return $model::find($id)->periksa->pasien->nama;
		}
	}
}
