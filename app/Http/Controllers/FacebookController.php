<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Pasien;
use App\Periksa;
use App\AntrianPeriksa;
use App\AntrianPoli;
use App\Classes\Yoga;
use App\FacebookDaftar;
use Socialite;
use Input;

class FacebookController extends Controller
{
   public function facebook()
    {
		return Socialite::driver('facebook')->fields([
			'name', 'email', 'gender', 'birthday'
		])->scopes([
			'email', 'user_birthday'
		])->with([
			'auth_type' => 'rerequest'
		])->redirect();
        //return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function callback()
    {
        $user = Socialite::driver('facebook')->fields([
			'name', 'email', 'gender', 'birthday'
		])->user();


		$id = $user->getId();
		$name = $user->getName();
		$email = $user->getEmail();

		$birthday = null;
		if (isset( $user['birthday'] )) {
			$birthday = $user['birthday'];
		}

		$pasien = $this->pasien($email, $id);
		$polis = $this->polis();
		if ($pasien != null) {
			if ($pasien->asuransi_id == '0') {
				$pembayarans = $this->pembayarans();
			}else {
				$pembayarans = [ 
					null => '-Pilih-', 
					'0' => 'Biaya Pribadi', 
					'1' => $pasien->asuransi->nama, 
					'2' => 'Asuransi Lain'
				];
			}
			return view('facebook/terdaftar', compact('pasien', 'user', 'polis', 'pembayarans'));
		} else {

			$date = $this->date();
			$month = $this->month();
			$pernah_berobat = $this->pernahBerobat();
			$year = $this->year();
			$pembayarans = $this->pembayarans();
			return view('facebook/tidak_terdaftar', compact(
				'user',
				'polis',
				'pembayarans',
				'date', 
				'month', 
				'birthday', 
				'pernah_berobat', 
				'year'
			));
		}
    }
	
	public function daftarkan(){
		//return dd( Input::all());
		//return dd( Input::get('pernah_berobat'));
		$pasien = $this->pasien(Input::get('email'), Input::get('facebook_id'));
		$email_pasien = Input::get('email');
		$pilihan_pembayaran = Input::get('pembayaran');

		if ($pasien != null) {
			$pasien_id = $pasien->id;
			$nama_pasien = null;
			$tanggal_lahir_pasien = null;
			$alamat_pasien = null;
			$no_hp_pasien = null;
		} else {
			$pasien_id = null;
			$nama_pasien = Input::get('nama');
			$tanggal_lahir_pasien = Input::get('year') . '-' . Input::get('month') . '-' . Input::get('date');
			$alamat_pasien = Input::get('alamat');
			$no_hp_pasien = Input::get('no_hp');
		}

		$fb = new FacebookDaftar;
		$fb->pasien_id = $pasien_id;
		if (!$pasien) {
			$fb->nama_pasien = $nama_pasien;
			$fb->tanggal_lahir_pasien = $tanggal_lahir_pasien;
			$fb->alamat_pasien = $alamat_pasien;
			$fb->no_hp_pasien = $no_hp_pasien;
			$fb->email_pasien = $email_pasien;
			$fb->pernah_berobat = Input::get('pernah_berobat');
		} else {
			$fb->nama_pasien = $pasien->nama;
			$fb->tanggal_lahir_pasien = $pasien->tanggal_lahir;
			$fb->alamat_pasien = $pasien->alamat;
			$fb->no_hp_pasien = $pasien->no_telp;
			$fb->email_pasien = $pasien->email;
			$fb->pernah_berobat = 1;
		}
		$fb->gender_id = Input::get('gender_id');
		$fb->facebook_id = Input::get('facebook_id');
		$fb->pilihan_poli = Input::get('poli');
		$fb->pilihan_pembayaran = $pilihan_pembayaran;
		$fb->save();

		if ($pasien && ( !$pasien->facebook_id || !$pasien->email )) {
			if (empty( $pasien->facebook_id )) {
				$pasien->facebook_id = Input::get('facebook_id');
			}
			if (empty( $pasien->email ) && !empty(Input::get('email'))) {
				$pasien->email = Input::get('email');
			}
			$pasien->save();
		}

		
		return redirect('facebook/' . $fb->id);
	}
	private function pasien($email, $facebook_id){
		$pasien= null;
		$pasienByFacebookId = Pasien::where('facebook_id', $facebook_id)->first();
		if ($pasienByFacebookId) {
			$pasien = $pasienByFacebookId;
		}
		return $pasien;
	}
	public function list(){
		$facebook_daftars = FacebookDaftar::where('verified', 0)->get();
		return view('facebook.list', compact('facebook_daftars'));
	}


	public function verification($id){
		$fb = FacebookDaftar::find($id);
		$pasiens = Pasien::where('tanggal_lahir', $fb->tanggal_lahir_pasien->format('Y-m-d'))->get();
		return view('facebook.verification', compact('fb', 'pasiens'));
	}
	public function verified($id, $pasien_id){
		
		$fb = FacebookDaftar::find($id);
		$pasien = Pasien::find($pasien_id);
		
		//return $fb->pilihan_poli;
		if (empty( $pasien->alamat )) {
			$pasien->alamat = $fb->alamat_pasien;
		}
		if (empty( $pasien->sex )) {
			if ($fb->gender_id == 'male') {
				$pasien->sex = 'L';
			} else {
				$pasien->sex = 'P';
			}
		}
		if (empty( $pasien->email )) {
			$pasien->email = $fb->email_pasien;
		}
		if (empty( $pasien->no_telp )) {
			$pasien->no_telp = $fb->no_hp_pasien;
		}
		if (empty( $pasien->facebook_id )) {
			$pasien->facebook_id = $fb->facebook_id;
		}

		if ($fb->pilihan_pembayaran == 0) {
			$pasien->asuransi_id = 0;
		}else if ($fb->pilihan_pembayaran == 2){
			$pasien->asuransi_id = null;
		}
		$ps = new Pasien;

		$statusPernikahan = $ps->statusPernikahan();
		$panggilan = $ps->panggilan();
		$asuransi = Yoga::asuransiList();
		$jenis_peserta = $ps->jenisPeserta();
		$staf = Yoga::stafList();
		$poli = Yoga::poliList();

		$antrian = $this->antrian();

		$fb->nama = $pasien->nama;
		$fb->asuransi_id = $pasien->asuransi_id;
		$fb->jenis_peserta = $pasien->jenis_peserta;
		$fb->nomor_asuransi = $pasien->nomor_asuransi;
		$fb->nama_peserta = $pasien->nama_peserta;
		$fb->alamat = $pasien->alamat;
		$fb->no_telp = $pasien->no_telp;
		$fb->email = $pasien->email;
		$fb->tanggal_lahir = $pasien->tanggal_lahir;
		$fb->sex = $pasien->sex;
		$fb->nama_ibu = $pasien->nama_ibu;
		$fb->nama_ayah = $pasien->nama_ayah;
		$fb->jenis_peserta = $pasien->jenis_peserta;
		$fb->image = $pasien->image;
		$fb->ktp_image = $pasien->ktp_image;
		$fb->bpjs_image = $pasien->bpjs_image;

		return view('facebook.verified', compact(
			'fb', 
			'pasien',
			'statusPernikahan',
			'panggilan',
			'asuransi',
			'antrian',
			'jenis_peserta',
			'staf',
			'poli'
		));
	}
	
	public function postVerified($fb_id, $id){

		$ps = new Pasien;

			if (empty(trim(Input::get('asuransi_id')))) {
				$asuransi_id = 0;
			} else {
				$asuransi_id = Input::get('asuransi_id');
			}

		$ps							= Pasien::find($id);
		$ps->nama					= Input::get('nama');
		$ps->nama_peserta			= Input::get('nama_peserta');
		$ps->nomor_asuransi			= Input::get('nomor_asuransi');
		$ps->asuransi_id			= $asuransi_id;
		if ($asuransi_id == '32') {
			$ps->nomor_asuransi_bpjs			= Input::get('nomor_asuransi');
		}
		$ps->jenis_peserta			= Input::get('jenis_peserta');
		$ps->sex					= Input::get('sex');
		$ps->tanggal_lahir			= Yoga::datePrep( Input::get('tanggal_lahir') );
		$ps->email					= Input::get('email');
		$ps->alamat					= Input::get('alamat');
		$ps->no_telp				= Input::get('no_hp');
		$ps->email					= Input::get('email');
		$ps->facebook_id			= Input::get('facebook_id');
		if (!empty(Input::get('image'))) {
			$ps->image      	= Yoga::inputImageIfNotEmpty(Input::get('image'), $id);
		}
		if (Input::hasFile('bpjs_image')) {
			$ps->bpjs_image     = $psn->imageUpload('bpjs','bpjs_image', $id);
		}
		if (Input::hasFile('ktp_image')) {
			$ps->ktp_image      = $psn->imageUpload('ktp', 'ktp_image', $id);
		}
		$ps->save();
		
		if (empty(Pasien::find($id)->image) && Input::get('asuransi_id') == '32') {
			return redirect('pasiens/' . $id . '/edit')->withCek('Gambar <strong>Foto pasien (bila anak2) atau gambar KTP pasien (bila DEWASA) </strong> harus dimasukkan terlebih dahulu');
		}

		$antrian_poli_id = Yoga::customId('App\AntrianPoli');

		$ap              = new Antrianpoli;
		$ap->antrian     = Input::get('antrian');
		$ap->asuransi_id = Input::get('asuransi_id');
		$ap->pasien_id   = $id;
		$ap->poli        = Input::get('poli');
		$ap->jam         = date("H:i:s");
		$ap->tanggal     = date('Y-m-d');
		$ap->id          = $antrian_poli_id;
		$ap->save();

		$fb = FacebookDaftar::find($fb_id);
		$fb->verified = 1;
		$fb->save();

		$pasien = Pasien::find($id);
		$pesan  = '<strong>' . $pasien->id . ' - ' . $pasien->nama . '</strong> Berhasil masuk antrian Nurse Station';

		return redirect('antrianpolis')->withPesan(Yoga::suksesFlash($pesan));
	}
	
	public function show($id){
		$fb = FacebookDaftar::find($id);
		return view('facebook.unverified', compact('fb'));
	}
	
	public function edit($id){
		$polis = $this->polis();
		$date = $this->date();
		$month = $this->month();
		$pernah_berobat = $this->pernahBerobat();
		$year = $this->year();
		$pembayarans = $this->pembayarans();
		$fb = FacebookDaftar::find($id);
		return view('facebook.edit_tidak_terdaftar', compact(
			'date',
			'month',
			'year',
			'polis',
			'pernah_berobat',
			'pembayarans',
			'fb'
		));
	}
	public function pernahBerobat(){
		
		$pernah_berobat[null] = '-Pilih-';
		$pernah_berobat[0] = 'Belum Pernah Berobat';
		$pernah_berobat[1] = 'Sudah Pernah Berobat';

		return $pernah_berobat;
	}
	public function date(){
		$date[null]= 'Tanggal';
		for ($i = 1; $i < 32; $i++) {
			$date[$i]= $i; 
		}
		return $date;
	}

	public function month(){
		$month[null] = 'Bulan';
		$month[1] = 'Januari';
		$month[2] = 'Februari';
		$month[3] = 'Maret';
		$month[4] = 'April';
		$month[5] = 'Mei';
		$month[6] = 'Juni';
		$month[7] = 'Juli';
		$month[8] = 'Agustus';
		$month[9] = 'September';
		$month[10] = 'Oktober';
		$month[11] = 'November';
		$month[12] = 'Desember';

		return $month;
	}
	public function year(){
		$year[null] = 'Tahun';
		$nextyear = date('Y') + 1;
		for ($i = 1900; $i < $nextyear; $i++) {
			$year[$i]= $i; 
		}

		return $year;
	}
	
	
	public function pembayarans(){
		return [ 
			null => '-Pilih-', 
			'0' => 'Biaya Pribadi', 
			'2' => 'Asuransi'
		];
	}
	
	public function polis(){
		return [ 
			null => '-Pilih-', 
			'umum' => 'Dokter Umum', 
			'gigi' => 'Dokter Gigi', 
			'anc' => 'Periksa Hamil',
			'kb 1 bulan' => 'Suntik KB 1 Bulan',
			'kb 3 bulan' => 'Suntik KB 3 Bulan',
			'usg' => 'USG (Ultrasonografi) Kehamilan',
			'usgabdomen' => 'USG (Ultrasonografi) tidak hamil'
		];
	}
	
	public function update($id){
		
		$fb = FacebookDaftar::find($id);
		$fb->pasien_id = Input::get('pasien_id');
		$fb->nama_pasien = Input::get('nama');
		$fb->tanggal_lahir_pasien = Input::get('year') . '-' . Input::get('month') . '-' . Input::get('date');
		$fb->alamat_pasien = Input::get('alamat');
		$fb->no_hp_pasien = Input::get('no_hp');
		$fb->gender_id = Input::get('gender_id');
		$fb->pilihan_poli = Input::get('poli');
		$fb->pilihan_pembayaran = Input::get('pembayaran');
		$fb->pernah_berobat = Input::get('pernah_berobat');
		$confirm = $fb->save();

		if ($confirm) {
			$pesan = Yoga::suksesFlash('Update data pasien Berhasil');
		}
		return redirect('facebook/' . $fb->id)->withPesan($pesan);
	}
	
	public function destroy($id){
		$confirm = FacebookDaftar::destroy($id);
		return redirect('facebook');
	}
	public function destroyOnApp($id){
		$fb = FacebookDaftar::find($id);
		if ($fb->delete()) {
			$pesan = Yoga::suksesFlash( $fb->nama_pasien . ' berhasil dihapus dari antrian');
		}
		return redirect()->back()->withPesan($pesan);
	}
	
	public function daftarkanRegistered(){
		//return Input::all();
		$facebook_id = Input::get('facebook_id');
		$pilihan_pembayaran = Input::get('pembayaran');
		$pasien = Pasien::where('facebook_id', $facebook_id)->first();


		if ($pilihan_pembayaran == 2 || ( $pilihan_pembayaran == 1 && $pasien->asuransi_id != '32' )) {

			$fb = new FacebookDaftar;
			$fb->nama_pasien = $pasien->nama;
			$fb->pasien_id = $pasien->id;
			$fb->tanggal_lahir_pasien = $pasien->tanggal_lahir;
			$fb->alamat_pasien = $pasien->tanggal_lahir;
			$fb->no_hp_pasien = $pasien->no_telp;
			$fb->email_pasien = $pasien->email;
			$fb->facebook_id = Input::get('facebook_id');
			$fb->gender_id = Input::get('gender_id');
			$fb->pernah_berobat = 1;
			$fb->pilihan_pembayaran = Input::get('pembayaran');
			$fb->pilihan_poli = Input::get('poli');
			$fb->save();

			$pesan = Yoga::gagalFlash('Verifikasi dulu asuransinya apakah boleh digunakan');
			return redirect('facebook/terdaftar/unverified/' . $fb->id)->withPesan($pesan);
		} else if($pilihan_pembayaran == 0 ||( $pilihan_pembayaran == 1 && $pasien->asuransi_id == '32' )) {
			$antrian = $this->antrian();
			$antrian_poli_id = Yoga::customId('App\AntrianPoli');

			$ap              = new Antrianpoli;
			$ap->antrian     = $antrian;
			if ($pilihan_pembayaran == 1) {
				$asuransi_id = $pasien->asuransi_id;
			} else {
				 $asuransi_id = 0;
			}
			$ap->asuransi_id = $asuransi_id;
			$ap->pasien_id   = $pasien->id;
			$ap->poli        = Input::get('poli');
			$ap->staf_id     = null;
			$ap->jam         = date("H:i:s");
			$ap->tanggal     = date('Y-m-d');
			$ap->id          = $antrian_poli_id;
			$confirm = $ap->save();


			if ($confirm) {
				$pesan = Yoga::suksesFlash('Anda berhasil masuk antrian');
			} else {
				$pesan = Yoga::gagalFlash('Anda gagal didaftarkan');
			}
			return redirect('facebook/terdaftar/di_antrian_poli/' . $ap->id)->withPesan($pesan);
		}
		return '3';
	}
	public function registerTerdaftar($id){
		$pasien = AntrianPoli::find($id);
		return view('facebook.terdaftar_di_antrian', compact('pasien'));
		
	}
	
	
	public function destroyAntrianPoli($id){
		AntrianPoli::destroy($id);
		$pesan = Yoga::suksesFlash('Anda berhasil batal berobat');
		return redirect('facebook/home')->withPesan($pesan);
	}
	public function home(){
		return view('facebook.home');
	}
	public function terdaftarUnverified($id){
		$fb = FacebookDaftar::find($id);
		return view('facebook.terdaftar_unverified', compact('fb'));
	}
	
	public function terdaftarUnverifiedEdit($id){
		$fb = FacebookDaftar::find($id);
		$polis = $this->polis();
		$pembayarans = $this->pembayarans();
		return view('facebook.terdaftar_unverified_edit', compact(
			'fb',
			'polis',
			'pembayarans'
		));
	}
	
	public function terdaftarUnverifiedUpdate($id){

		//return Input::all();
		$facebook_id = Input::get('facebook_id');
		$pilihan_pembayaran = Input::get('pembayaran');
		$pasien = Pasien::where('facebook_id', $facebook_id)->first();


		if ($pilihan_pembayaran == 2 || ( $pilihan_pembayaran == 1 && $pasien->asuransi_id != '32' )) {
			$fb = FacebookDaftar::find($id);
			$fb->pilihan_pembayaran = Input::get('pembayaran');
			$fb->pilihan_poli = Input::get('poli');
			$fb->save();

			return redirect('facebook/terdaftar/unverified/' . $fb->id)->withPesan($pesan);
		} else if($pilihan_pembayaran == 0 ||( $pilihan_pembayaran == 1 && $pasien->asuransi_id == '32' )) {
			FacebookDaftar::destroy($id);
			$antrian = AntrianPoli::latest()->first()->antrian + 1;
			$antrian_poli_id = Yoga::customId('App\AntrianPoli');

			$ap              = new Antrianpoli;
			$ap->antrian     = $antrian;
			if ($pilihan_pembayaran == 1) {
				$asuransi_id = $pasien->asuransi_id;
			} else {
				 $asuransi_id = 0;
			}
			$ap->asuransi_id = $asuransi_id;
			$ap->pasien_id   = $pasien->id;
			$ap->poli        = Input::get('poli');
			$ap->staf_id     = null;
			$ap->jam         = date("H:i:s");
			$ap->tanggal     = date('Y-m-d');
			$ap->id          = $antrian_poli_id;
			$confirm = $ap->save();


			if ($confirm) {
				$pesan = Yoga::suksesFlash('Anda berhasil masuk antrian');
			} else {
				$pesan = Yoga::gagalFlash('Anda gagal didaftarkan');
			}
			return redirect('facebook/terdaftar/di_antrian_poli/' . $ap->id)->withPesan($pesan);
		}
		return '3';
	}
	
	public function inputPasienBaru($id){
		$pasien = new Pasien;

		$statusPernikahan = $pasien->statusPernikahan();
		$panggilan = $pasien->panggilan();
		$asuransi = Yoga::asuransiList();
		$jenis_peserta = $pasien->jenisPeserta();
		$staf = Yoga::stafList();
		$poli = Yoga::poliList();
		$fb = FacebookDaftar::find($id);

		$fb->nama = $fb->nama_pasien;
		$fb->alamat = $fb->alamat_pasien;
		$fb->no_telp = $fb->no_hp_pasien;
		$fb->email = $fb->email_pasien;
		if ($fb->gender_id == 'male') {
			$fb->sex = 'L';
		}else if ($fb->gender_id == 'female'){
			$fb->sex = 'P';
		} else {
			$fb->sex =null;
		}
		$fb->tanggal_lahir = $fb->tanggal_lahir_pasien->format('d-m-Y');
		$antrian = $this->antrian();

		return view('facebook.input_pasien_baru', compact(
			'fb',
			'statusPernikahan',
			'panggilan',
			'asuransi',
			'antrian',
			'jenis_peserta',
			'staf',
			'poli'
		));
	}
	
	public function antrian(){
		$antrianPoli = 0;
		$antrianPeriksa = 0;
		$periksa = 0;
		if (AntrianPoli::where('tanggal', date('Y-m-d'))->count() > 0) {
			$antrianPoli = AntrianPoli::where('tanggal', date('Y-m-d'))->orderBy('antrian', 'desc')->first()->antrian;
		}
		if (AntrianPeriksa::where('tanggal', date('Y-m-d'))->count() > 0) {
			$antrianPeriksa = AntrianPeriksa::where('tanggal', date('Y-m-d'))->orderBy('antrian', 'desc')->first()->antrian;
		}
		if ($periksa) {
			$periksa = Periksa::where('tanggal', date('Y-m-d'))->orderBy('antrian', 'desc')->first()->antrian;
		}


		$antri = [
			 $antrianPoli,
			 $antrianPeriksa,
			 $periksa
		];

		return max($antri) + 1;
	}
	
	public function postPasienBaru($facebook_daftar_id){
			
			$id = Yoga::customId('App\Pasien');

			if (empty(trim(Input::get('asuransi_id')))) {
				$asuransi_id = 0;
			} else {
				$asuransi_id = Input::get('asuransi_id');
			}

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
			if ( $asuransi_id == '32') {
				$pasien->nomor_asuransi_bpjs = Input::get('nomor_asuransi');
			}
			$pasien->facebook_id = Input::get('facebook_id');
			$pasien->email = Input::get('email');
			$pasien->no_telp        = Input::get('no_telp');
			$pasien->tanggal_lahir  = Yoga::datePrep(Input::get('tanggal_lahir'));
			$pasien->id             = $id;
			$pasien->bpjs_image     = $pasien->imageUpload('bpjs','bpjs_image', $id);
			$pasien->ktp_image      = $pasien->imageUpload('ktp', 'ktp_image', $id);
			$pasien->image          = Yoga::inputImageIfNotEmpty(Input::get('image'), $id);
			$pasien->save();


			$antrian_poli_id = Yoga::customId('App\AntrianPoli');
			$ap              = new Antrianpoli;
			$ap->antrian     = Input::get('antrian');
			$ap->asuransi_id = $pasien->asuransi_id;
			$ap->pasien_id   = $id;
			$ap->poli        = Input::get('poli');
			$ap->staf_id     = null;
			$ap->jam         = date("H:i:s");
			$ap->tanggal     = date('Y-m-d');
			$ap->id          = $antrian_poli_id;
			$confirm = $ap->save();

			if ($confirm) {
				$pesan = Yoga::suksesFlash('Pasien Baru dengan nama <strong>' . $id . '-' . $pasien->nama .'</strong> Berhasil Dibuat');
				FacebookDaftar::destroy($facebook_daftar_id);
			} else {
				$pesan = Yoga::gagalFlash('Pasien Baru Gagal Dibuat');
			}
			return redirect('antrianpolis')->withPesan($pesan);
	}
	
	
	
}
