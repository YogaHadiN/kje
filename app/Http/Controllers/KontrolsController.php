<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Periksa;
use App\Models\Kontrol;
use App\Models\Classes\Yoga;
use Input;

class KontrolsController extends Controller
{
	public function create($periksa_id){
		$periksa = Periksa::find($periksa_id);
		return view('kontrols.create', compact('poli', 'periksa'));
	}
	public function store(){
		$rules = [
		  "periksa_id" => "required",
		  "tanggal" => "required",
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$periksa = Periksa::find( Input::get('periksa_id') );

		$k             = new Kontrol;
		$k->periksa_id = Input::get('periksa_id');
		$k->tanggal    = Yoga::datePrep( Input::get('tanggal') );
		$confirm = $k->save();
		if ($confirm) {
			$pesan = Yoga::suksesFlash('Janji Kontrol Sudah Dibuat');
		} else {
			$pesan = Yoga::gagalFlash('Janji Kontrol Gagal Dibuat');
		}

		$jenis_antrian_id = '6';
		if (!is_null( $periksa->antrian )) {
			$jenis_antrian_id = $periksa->antrian->jenis_antrian_id;
		}
		
		return redirect('ruangperiksa/' . $jenis_antrian_id)->withPesan($pesan);

	}
	public function update($id){
		$rules = [
		  "periksa_id" => "required",
		  "tanggal" => "required",
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		$k       = Kontrol::find($id);
		$k->periksa_id = Input::get('periksa_id');
		$k->tanggal = Yoga::datePrep( Input::get('tanggal') );
		$confirm = $k->save();

		$periksa = Periksa::find( Input::get('periksa_id') );
		if ($confirm) {
			$pesan = Yoga::suksesFlash('Update Janji Kontrol Berhasil');
		} else {
			$pesan = Yoga::gagalFlash('Update Janji Kontrol Gagal');
		}
		$jenis_antrian_id = '6';
		if ( !is_null($periksa->antrian) ) {
			$jenis_antrian_id = $periksa->antrian->jenis_antrian_id
		}
		return redirect('ruangperiksa/' . $jenis_antrian_id)->withPesan($pesan);
	}
	
	public function edit($id){
		$kontrol = Kontrol::find($id);
		$periksa = Periksa::find($kontrol->periksa_id);
		return view('kontrols.edit', compact('kontrol', 'periksa'));
	}
	public function destroy($id){
		$periksa = Periksa::find( Input::get('periksa_id') );
		$confirm = Kontrol::destroy($id);
		if ($confirm) {
			$pesan = Yoga::suksesFlash('Jadwal kontrol berhasil dibatalkan');
		}
		$jenis_antrian_id = '6';
		if ( !is_null($periksa->antrian) ) {
			$jenis_antrian_id = $periksa->antrian->jenis_antrian_id
		}
		return redirect('ruangperiksa/' . $jenis_antrian_id)->withPesan($pesan);
	}
	
	
	
}
