<?php

namespace App\Http\Controllers;

use Input;
use App\Http\Requests;
use DB;
use Auth;
use Hash;
use App\AntrianPoli;
use App\User;
use App\Periksa;
use App\Staf;
use App\AntrianPeriksa;
use App\Pasien;
use App\Classes\Yoga;

class PasiensAjaxController extends Controller
{

	/**
	 * Display a listing of the resource.
	 * GET /pasiensajax
	 *
	 * @return Response
	 */
	
	public function ajaxpasiens(){

		if(Input::ajax()){

			$ID_PASIEN = Input::get('id');
		    $nama= Input::get('nama');
            $array = str_split($nama);
            $namaPasien = '';
            foreach ($array as $arr) {
                $namaPasien .= $arr . '%';
            }
		    $alamats = Input::get('alamat');
            $array = str_split($alamats);
            $alamat = '';
            foreach ($array as $arr) {
                $alamat .= $arr . '%';
            }
		    $tanggalLahir = Input::get('tanggal_lahir');
		    $noTelp = Input::get('no_telp');
		    $namaIbu = Input::get('nama_ibu');
		    $namaAyah = Input::get('nama_ayah');
		    $namaPeserta = Input::get('nama_peserta');
		    $namaAsuransi = Input::get('nama_asuransi');
		    $nomorAsuransi = Input::get('nomorAsuransi');

		    $query  = "SELECT p.asuransi_id, p.id as ID_PASIEN, p.nama as namaPasien, p.alamat, p.tanggal_lahir as tanggalLahir, p.no_telp as noTelp, asu.nama as namaAsuransi, p.nomor_asuransi as nomorAsuransi, p.nama_peserta as namaPeserta, p.nama_ibu as namaIbu, p.nama_ayah as namaAyah, p.image as image ";
		    $query .= "FROM pasiens as p left outer join asuransis as asu on p.asuransi_id = asu.id ";
		    $query .= "WHERE ";
		    $query .= "(p.id like '%{$ID_PASIEN}%' or '{$ID_PASIEN}' = '') ";
		    $query .= "AND (p.nama like '%{$namaPasien}' or '{$namaPasien}' = '') ";
		    $query .= "AND (p.alamat like '%{$alamat}' or '{$alamat}' = '') ";
		    $query .= "AND (p.tanggal_lahir like '%{$tanggalLahir}%' or '{$tanggalLahir}' = '') ";
		    $query .= "AND (p.no_telp like '%{$noTelp}%' or '{$noTelp}' = '') ";
		    $query .= "AND (asu.nama like '%{$namaAsuransi}%' or '{$namaAsuransi}' = '') ";
		    $query .= "AND (p.nomor_asuransi like '%{$nomorAsuransi}%' or '{$nomorAsuransi}' = '') ";
		    $query .= "AND (p.nama_peserta like '%{$namaPeserta}%' or '{$namaPeserta}' = '') ";
		    $query .= "AND (p.nama_ibu like '%{$namaIbu}%' or '{$namaIbu}' = '') ";
		    $query .= "AND (p.nama_ayah like '%{$namaAyah}%' or '{$namaAyah}' = '') ORDER BY p.id DESC LIMIT 15 ";

		    return json_encode(DB::select($query));

		}
	}

	public function ajaxpasien(){


			$antrian = Input::get('antrian');
			$nama = '';

			$count = AntrianPoli::where('antrian', $antrian)->get()->count() + AntrianPeriksa::where('antrian', $antrian)->get()->count();

			if(AntrianPoli::where('antrian', $antrian)->get()->count() > 0){
				$id = AntrianPoli::where('antrian', $antrian)->first()->pasien_id;

				$nama = Pasien::find($id)->nama;
			} else if (AntrianPeriksa::where('antrian', $antrian)->get()->count() > 0){
				$id = AntrianPeriksa::where('antrian', $antrian)->first()->pasien_id;

				$nama = Pasien::find($id)->nama;
			}

			$antrian_pesan = '';

			if($count > 0){
				$antrian_pesan = $nama;
			} else {
				$antrian_pesan = '';
			}

			$pasien_id = Input::get('pasien_id');

			$count = AntrianPoli::where('pasien_id', $pasien_id)->get()->count() + AntrianPeriksa::where('pasien_id', $pasien_id)->get()->count();

			$pasien_pesan = '';

			if($count > 0){
				$pasien_pesan = Pasien::find($pasien_id)->nama;
			}

			$data = [
				'antrian' => $antrian_pesan,
				'pasien' => $pasien_pesan
			];

			return json_encode($data);

	}

	public function create()
	{
		if(Input::ajax()){
			$id = Yoga::customIdPasien();
			// return Yoga::inputKtpIfNotEmpty(Input::get('ktp_image'), $id);
			// return Yoga::inputImageIfNotEmpty(Input::get('image'), $id);
			// return Input::get('image');
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
			$pasien->no_telp        = Input::get('no_telp');
			$pasien->tanggal_lahir  = Yoga::datePrep(Input::get('tanggal_lahir'));
			$pasien->id             = $id;
			$pasien->image          = Yoga::inputImageIfNotEmpty(Input::get('image'), $id);
			$pasien->ktp_image      = Yoga::inputKtpIfNotEmpty(Input::get('ktp_image'), $id);
		
			$pasien->save();

			$query = "SELECT asu.nama as nama_asuransi, p.* FROM pasiens as p LEFT OUTER JOIN asuransis as asu on p.asuransi_id = asu.id WHERE p.id = '" . $id . "'";
			
			return DB::SELECT($query);

		} else {

			$validator = \Validator::make($data = Input::all(), Pasien::$rules);

			if ($validator->fails())

			{
				return \Redirect::back()->withErrors($validator)->withInput();
			}

			Pasien::create($data);

			return \Redirect::route('pasiens.index');
		}

	}

	public function cekbpjskontrol()
	{

		$pasien_id   = Input::get('pasien_id');
		$pasien = Pasien::find($pasien_id);
		$asuransi_id = $pasien->asuransi_id;
		$cekGDSBulanIni = Yoga::cekGDSBulanIni($pasien, null);
		$tanggal = $cekGDSBulanIni['tanggal'];
		$pemeriksaanTerakhir = Periksa::where('pasien_id', $pasien_id)->latest()->first();
		$pakaiBayarPribadi = Yoga::pakaiBayarPribadi($asuransi_id, $pasien_id, $pemeriksaanTerakhir);


		if(
			$pakaiBayarPribadi	 &&
			$cekGDSBulanIni['bayar'])
		{
			$kembali = ['kode' => '3', 'tanggal' => $tanggal];
		} elseif($pakaiBayarPribadi){
			$kembali = ['kode' => '2', 'tanggal' => $tanggal];
		} elseif($cekGDSBulanIni['bayar']) {
			$kembali = ['kode' => '1', 'tanggal' => $tanggal];
		} else {
			$kembali = ['kode' => '0', 'tanggal' => $tanggal];
		}

		return json_encode($kembali);
	}

    public function confirm_staf(){
        $email = Input::get('email');
        $password = Input::get('password');
        $pasien_id = Input::get('pasien_id');
        //return Input::all();

        $user = User::where('email', $email)->first();
        if ($user) {
           $hashedPassword = $user->password; 
        } else {
            $pesan = Yoga::gagalFlash('User belum terdaftar');
            return redirect('pasiens')->withPesan($pesan);
        }

		if( Hash::check($password, $hashedPassword) ){
            $staf= Staf::where('email', $email)->first();
            //return $staf->id;
            $count = Periksa::where('pasien_id', $pasien_id)
                            ->where('staf_id', $staf->id)
                            ->count();
            if ($count > 0 || $email == 'yoga_email@yahoo.com') {
                $pesan = Yoga::suksesFlash('Anda diizinkan untuk melihat status pasien ini <strong>harap jaga kerahasiannya</strong>');
                return redirect('pasiens/' . Input::get('pasien_id'))->withPesan($pesan);
            }else{
                $pesan = Yoga::gagalFlash('Anda tidak memiliki wewenang untuk melihat riwayat pasien ini');
                return redirect('pasiens')->withPesan($pesan);
            }
		}else {
            $pesan = Yoga::gagalFlash('Kombinasi email / password <strong>salah</strong>');
			return redirect('pasiens')
			->withPesan($pesan);
		}

    }
    
	public function ajax_pasien_show(){
	}
	

}
