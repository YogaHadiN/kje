<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Fasilitas;
use App\Pasien;
use App\AntrianPeriksa;
use App\Kabur;
use App\AntrianPoli;
use App\Classes\Yoga;
use App\RumahSakit;

class FasilitasController extends Controller
{
    public function antrian_pasien(){
		$antrianperiksa = AntrianPeriksa::with('pasien')->orderBy('antrian')->take(10)->get(['pasien_id', 'antrian']);
		return view('fasilitas.antrian', compact('antrianperiksa'));
    }
    public function survey(){
		return view('surveys.survey');
    }
	public function input_telp(){
		return view('fasilitas.input_telp', compact(''));
	}
	public function input_tgl_lahir($poli){
		return view('fasilitas.input_tgl_lahir', compact(
			'poli'
		));
	}
	public function post_tgl_lahir($poli){
		$tanggal = Yoga::datePrep( Input::get('tanggal_lahir') );
		$pasiens = Pasien::where('tanggal_lahir', $tanggal)->get();
		return view('fasilitas.cari_pasien', compact(
			'pasiens',
			'poli',
			'tanggal'
		));
	}
	public function cari_asuransi($poli, $pasien_id){
		$tanggal = Input::get('tanggal');
		$pasien = Pasien::find($pasien_id);
		if ($poli == 'estetika') {
			$pesan = $this->postAntrianPoli($poli, $pasien_id, 0);
			return redirect('fasilitas/antrian_pasien')->withPesan($pesan);
		}
		return view('fasilitas.cari_asuransi', compact(
			'tanggal',
			'poli',
			'pasien'
		));
	}
	public function submit_antrian($poli, $pasien_id, $asuransi_id){
		$pesan = $this->postAntrianPoli($poli, $pasien_id, $asuransi_id);
		return redirect('fasilitas/antrian_pasien')->withPesan($pesan);

		

	}
	public function postAntrianPoli($poli, $pasien_id, $asuransi_id){
		$antrianPoli = ( isset( AntrianPoli::orderBy('antrian', 'desc')->first()->antrian ) )?  AntrianPoli::orderBy('antrian', 'desc')->first()->antrian : null;
		$antrianPeriksa = ( isset( AntrianPeriksa::orderBy('antrian', 'desc')->first()->antrian ) )? AntrianPeriksa::orderBy('antrian', 'desc')->first()->antrian : null; 
		$antrian = [
			$antrianPeriksa,
			$antrianPoli
		];
		$antrian = (int)max($antrian) + 1; 
		$antrian_poli_id = Yoga::customId('App\AntrianPoli');
		$ap       = new AntrianPoli;
		$ap->id   = $antrian_poli_id;
		$ap->poli   = $poli;
		$ap->pasien_id   = $pasien_id;
		if ($asuransi_id !='x') {
			$ap->asuransi_id   = $asuransi_id;
		}
		$ap->tanggal   = date('Y-m-d');
		$ap->jam   = date('H:i:s');
		$ap->self_register   = 1;
		$ap->antrian   = $antrian;
		$ap->asuransi_id   = $asuransi_id;
		$confirm = $ap->save();
		if ($confirm) {
			$pesan = Yoga::suksesFlash( '<strong>' . $ap->pasien->id . ' - ' . $ap->pasien->nama . '</strong> Berhasil masuk antrian' );
			if ($asuransi_id != '0' && $asuransi_id != '32') {
				$pesan .= " Mohon berikan kartu asuransi / pengantar berobat ke kasir";
			}
		} else {
			$pesan = Yoga::gagalFlash('<strong>' . $ap->pasien->id . ' - ' . $ap->pasien->nama . '</strong> Gagal masuk antrian');
		}			

		return $pesan;
	}
	
	
	public function konfirmasi(){
		$id = Input::get('konfirmasi_antrian_poli_id');
		$ap       = AntrianPoli::find($id);
		$ap->self_register   = null;
		$confirm = $ap->save();
		if ($confirm) {
			$pesan = Yoga::suksesFlash(''  . $ap->pasien_id . ' - ' . $ap->pasien->nama . ' <strong>BERHASIL</strong> ');
		} else {
			$pesan = Yoga::gagalFlash(''  . $ap->pasien_id . ' - ' . $ap->pasien->nama . ' <strong>GAGAL</strong> ');
		}
		return redirect()->back()->withPesan($pesan);
	}
	
	
	public function antrianPoliDestroy(){
		$rules = [
			'id' => 'required',
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}


		$kb       = new Kabur;
		$kb->pasien_id   = Input::get('pasien_id');
		$kb->alasan   = Input::get('alasan_kabur');
		$kb->save();

		$confirm = AntrianPoli::destroy( Input::get('id') );

		if ($confirm) {
			$pesan = Yoga::suksesFlash('Antrian berhasil dihapus');
		} else {
			$pesan = Yoga::gagalFlash('Antrian gagal dihapus');
		}

		return redirect()->back()->withPesan($pesan);


	}
	
}
