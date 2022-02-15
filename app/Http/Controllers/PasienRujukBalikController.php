<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasienRujukBalik;
use Input;
use App\Models\Classes\Yoga;
use DB;

class PasienRujukBalikController extends Controller
{
	public function index(){
		$pasien_rujuk_baliks = PasienRujukBalik::all();
		return view('pasien_rujuk_baliks.index', compact(
			'pasien_rujuk_baliks'
		));
	}
	public function create(){
		return view('pasien_rujuk_baliks.create');
	}
	public function edit($id){
		$pasien_rujuk_balik = PasienRujukBalik::find($id);
		return view('pasien_rujuk_baliks.edit', compact('pasien_rujuk_balik'));
	}
	public function store(Request $request){
		if ($this->valid( Input::all() )) {
			return $this->valid( Input::all() );
		}
		$pasien_rujuk_balik       = new PasienRujukBalik;
		// Edit disini untuk simpan data
		$pasien_rujuk_balik->save();
		$pesan = Yoga::suksesFlash('PasienRujukBalik baru berhasil dibuat');
		return redirect('pasien_rujuk_baliks')->withPesan($pesan);
	}
	public function update($id, Request $request){
		if ($this->valid( Input::all() )) {
			return $this->valid( Input::all() );
		}
		$pasien_rujuk_balik     = PasienRujukBalik::find($id);
		// Edit disini untuk simpan data
		$pasien_rujuk_balik->save();
		$pesan = Yoga::suksesFlash('PasienRujukBalik berhasil diupdate');
		return redirect('pasien_rujuk_baliks')->withPesan($pesan);
	}
	public function destroy($id){
		PasienRujukBalik::destroy($id);
		$pesan = Yoga::suksesFlash('PasienRujukBalik berhasil dihapus');
		return redirect('pasien_rujuk_baliks')->withPesan($pesan);
	}
	public function import(){
		return 'Not Yet Handled';
		$file      = Input::file('file');
		$file_name = $file->getClientOriginalName();
		$file->move('files', $file_name);
		$results   = Excel::load('files/' . $file_name, function($reader){
			$reader->all();
		})->get();
		$pasien_rujuk_baliks     = [];
		$timestamp = date('Y-m-d H:i:s');
		foreach ($results as $result) {
			$pasien_rujuk_baliks[] = [
	
				// Do insert here
	
				'created_at' => $timestamp,
				'updated_at' => $timestamp
			];
		}
		PasienRujukBalik::insert($pasien_rujuk_baliks);
		$pesan = Yoga::suksesFlash('Import Data Berhasil');
		return redirect()->back()->withPesan($pesan);
	}
	private function valid( $data ){
		$messages = [
			'required' => ':attribute Harus Diisi',
		];
		$rules = [
			'data'           => 'required',
		];
		$validator = \Validator::make($data, $rules, $messages);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
	}
}
