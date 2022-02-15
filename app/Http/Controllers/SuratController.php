<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Image;
use App\Models\Classes\Yoga;
use App\Models\Surat;
use DB;
class SuratController extends Controller
{
	/**
	* @param 
	*/
	public function __construct()
	{
        $this->middleware('admin', ['except' => []]);
	}
	
	public function index(){
		$surats = Surat::all();
		return view('surats.index', compact(
			'surats'
		));
	}
	public function create(){
		return view('surats.create');
	}
	public function edit($id){
		$surat = Surat::find($id);
		return view('surats.edit', compact('surat'));
	}
	public function store(Request $request){
		if ($this->valid( Input::all() )) {
			return $this->valid( Input::all() );
		}
		$surat              = new Surat;
		$surat->nomor_surat = Input::get('nomor_surat');
		$surat->tanggal     = Yoga::datePrep(Input::get('tanggal'));
		$surat->surat_masuk = Input::get('surat_masuk');
		$surat->alamat      = Input::get('alamat');
		$surat->save();

		$surat->foto_surat  = $this->imageUpload('surat', 'foto_surat', $surat->id, 'img/surat');
		$surat->save();
		$pesan = Yoga::suksesFlash('Surat baru berhasil dibuat');
		return redirect('surats')->withPesan($pesan);
	}
	public function update($id, Request $request){
		if ($this->valid( Input::all() )) {
			return $this->valid( Input::all() );
		}
		$surat              = Surat::find($id);
		$surat->nomor_surat = Input::get('nomor_surat');
		$surat->tanggal     = Yoga::datePrep(Input::get('tanggal'));
		$surat->surat_masuk = Input::get('surat_masuk');
		if (Input::hasFile('foto_surat')) {
			$surat->foto_surat  = $this->imageUpload('surat', 'foto_surat', $surat->id, 'img/surat');
		}
		$surat->alamat      = Input::get('alamat');
		$surat->save();
		$pesan = Yoga::suksesFlash('Surat berhasil diupdate');
		return redirect('surats')->withPesan($pesan);
	}
	public function destroy($id){
		Surat::destroy($id);
		$pesan = Yoga::suksesFlash('Surat berhasil dihapus');
		return redirect('surats')->withPesan($pesan);
	}
	public function import(){
		return 'Not Yet Handled';
		$file      = Input::file('file');
		$file_name = $file->getClientOriginalName();
		$file->move('files', $file_name);
		$results   = Excel::load('files/' . $file_name, function($reader){
			$reader->all();
		})->get();
		$surats     = [];
		$timestamp = date('Y-m-d H:i:s');
		foreach ($results as $result) {
			$surats[] = [
				'created_at' => $timestamp,
				'updated_at' => $timestamp
			];
		}
		Surat::insert($surats);
		$pesan = Yoga::suksesFlash('Import Data Berhasil');
		return redirect()->back()->withPesan($pesan);
	}
	private function valid( $data ){
		$messages = [
			'required' => ':attribute Harus Diisi',
		];
		$rules = [
			'nomor_surat' => 'required',
			'tanggal'     => 'required',
			'surat_masuk' => 'required',
			'alamat'      => 'required'
		];
		$validator = \Validator::make($data, $rules, $messages);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
	}

	private function imageUpload($pre, $fieldName, $id, $path){
		if(Input::hasFile($fieldName)) {

			$upload_cover = Input::file($fieldName);
			//mengambil extension
			$extension = $upload_cover->getClientOriginalExtension();

			/* $upload_cover = Image::make($upload_cover); */
			/* $upload_cover->resize(1000, null, function ($constraint) { */
			/* 	$constraint->aspectRatio(); */
			/* 	$constraint->upsize(); */
			/* }); */

			//membuat nama file random + extension
			$filename =	 $pre . $id . '_' . time() . '.' . $extension;
			//
			//menyimpan bpjs_image ke folder public/img
			$destination_path = $path . '/';
			/* $destination_path = public_path() . DIRECTORY_SEPARATOR .$path . '/'; */

			// Mengambil file yang di upload
			/* $upload_cover->save($destination_path . '/' . $filename); */
			Storage::disk('s3')->put($destination_path. $filename, file_get_contents($upload_cover));
			
			//mengisi field bpjs_image di book dengan filename yang baru dibuat
			return $filename;
			
		} else {
			return null;
		}
	}
}
