<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Pasien;
use App\Models\Prolanis;
use App\Models\Classes\Yoga;
use DB;
use Input;

class ProlanisController extends Controller
{
	public function index(){
		$prolanis = Yoga::prolanis();
		$hipertensi = Pasien::find( $prolanis['pasien_ht'] );
		$dm = Pasien::with('periksa.transaksii')->whereIn('id', $prolanis['pasien_dm'] )->get();
        return view('prolanis.index', compact(
            'hipertensi',
            'dm'
        ));
	}

	public function terdaftar(){
		
		$prolanis = Prolanis::all();
		return view('prolanis.terdaftar', compact('prolanis'));
	}
	public function create($id){
		$pasien = Pasien::find($id);
		$golongan_prolanis = $this->golonganProlanis();
		return view('prolanis.create', compact(
			'pasien',
			'golongan_prolanis'
		));
	}

	public function store(){
		$rules = [
			'pasien_id' => 'required',
			'golongan_prolanis_id' => 'required'
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		$p       = new Prolanis;
		$p->pasien_id   = Input::get('pasien_id');
		$p->golongan_prolanis_id   = Input::get('golongan_prolanis_id');
		$confirm = $p->save();
		if( Input::get('golongan_prolanis_id') == '1' ){
			$golonganProlanis = 'Hipertensi';
		} else {
			$golonganProlanis = 'Diabetes Mellitus';
		}
		if ($confirm) {
			$pesan = Yoga::suksesFlash('Pasien BERHASIL mendapat status <strong>Prolanis Golongan ' . $golonganProlanis .  '</strong> ');
		} else {
			$pesan = Yoga::gagalFlash('Pasien GAGAL mendapat status <strong>Prolanis Golongan ' . $golonganProlanis .  '</strong> ');
		}

		return redirect('pasiens/' . Input::get('pasien_id') . '/edit')->withPesan($pesan);
		
	}
	public function edit($id){
		$prolanis = Prolanis::find($id);
		$pasien = $prolanis->pasien;
		$golongan_prolanis = $this->golonganProlanis();

		return view('prolanis.edit', compact(
			'prolanis',
			'pasien',
			'golongan_prolanis'
		));
		
	}

	public function update($id){
		$rules = [
			'pasien_id' => 'required',
			'golongan_prolanis_id' => 'required'

		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$p       = Prolanis::find($id);
		$p->golongan_prolanis_id   = Input::get('golongan_prolanis_id');
		$confirm = $p->save();
		if ($confirm) {
			$pesan = Yoga::suksesFlash('Prolanis pasien BERHASIL diubah');
		} else {
			$pesan = Yoga::gagalFlash('Prolanis pasien GAGAL diubah');
		}
		return redirect('pasiens/' . $p->pasien_id . '/edit')->withPesan($pesan);
	}
	

	private function golonganProlanis(){
		return [
			null => ' - pilih - ',
			'1' => 'Hipertensi',
			'2' => 'Diabetes Mellitus'
		] ;
	}

	public function destroy($id){
		$prolanis = Prolanis::find($id);
		$pasien = $prolanis->pasien;
		if ( $prolanis->delete() ) {
			$pesan = Yoga::suksesFlash('Prolanis ' . $pasien->nama . ' BERHASIL dihapus');
		}else {
			$pesan = Yoga::gagalFlash('Prolanis ' . $pasien->nama . ' GAGAL dihapus');
		}
		return redirect('pasiens/' . $pasien->id . '/edit')->withPesan($pesan);
	}
	
	
	
	
	
	
}
