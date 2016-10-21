<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Classes\Yoga;
use App\AntrianPoli;
use App\PengantarPasien;
use App\Pasien;
use Input;

class AntrianPolisAjaxController extends Controller
{
    //
	public function getProlanis(){
		$pasien_id = Input::get('pasien_id');
		return Yoga::golonganProlanis($pasien_id);
	}
	public function storePasienAjax(){
		$pasien_id = Yoga::customId('App\Pasien');
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
				'nama' => $ps->nama
			];
			
			return json_encode( [
				'confirm' => '1',
				'insert' => $data
			] );
		} else {
			return json_encode( ['confirm' => 0] );
		}
	}
}
