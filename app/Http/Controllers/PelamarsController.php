<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Pelamar;
use App\Classes\Yoga;
use Input;
use Image;

class PelamarsController extends Controller
{
	public function index(){
		$pelamars = Pelamar::latest()->paginate(20);
		return view('pelamars.index', compact('pelamars'));
	}
	public function edit($id){
		$pelamar = Pelamar::find($id);
		return view('pelamars.edit', compact('pelamar'));
	}
	
	public function create(){
		return view('pelamars.create', compact(''));
	}
	public function store(){
		$rules = [
			'nama' => 'required',
			'no_ktp' => 'required',
			'no_telp' => 'required'
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$p       = new Pelamar;
		$p->nama   = Input::get('nama');
		$p->no_ktp   = Input::get('no_ktp');
		$p->no_telp   = Input::get('no_telp');
		$confirm = $p->save();
		$p->image   = $this->imageUpload('pelamar', 'image', $p->id);
		$p->save();

		if ($confirm) {
			$pesan = Yoga::suksesFlash('pelamar'  . $p->id . ' - ' . $p->nama . ' <strong>BERHASIL</strong> Dibuat');
		} else {
			$pesan = Yoga::gagalFlash('pelamar'  . $p->id . ' - ' . $p->nama . ' <strong>GAGAL</strong> Dibuat');
		}
		return redirect('pelamars')->withPesan($pesan);
	}
	
	public function update($id){
		$rules = [
			'nama' => 'required',
			'no_ktp' => 'required',
			'no_telp' => 'required'
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		
		$pelamar          = Pelamar::find($id);
		$pelamar->nama    = Input::get('nama');
		$pelamar->no_ktp  = Input::get('no_ktp');
		$pelamar->no_telp = Input::get('no_telp');
		$pelamar->image   = $this->imageUpload('pelamar', 'image', $id);
		$confim = $pelamar->save();
		if ($confirm) {
			$pesan = Yoga::suksesFlash('Pelamar'  . $pelamar->id . ' - ' . $pelamar->nama . ' <strong>BERHASIL</strong> diUpdate');
		} else {
			$pesan = Yoga::gagalFlash('Pelamar'  . $pelamar->id . ' - ' . $pelamar->nama . ' <strong>GAGAL</strong> diUpdate');
		}
		return redirect('pelamars')->withPesan($pesan);
		
	}

	public function destroy($id){
		$pelamar = Pelamar::find($id);
		$nama = $pelamar->nama;

		$confirm = $pelamar->delete();

		if ($confirm) {
			$pesan = Yoga::suksesFlash('Pelamar ' . $nama . ' <strong>BERHASIL</strong> Dihapus');
		} else {
			$pesan = Yoga::gagalFlash('Pelamar ' . $nama . ' <strong>GAGAL</strong> Dihapus');
		}

		return redirect('pelamars')->withPesan($pesan);

		
	}
	

	private function imageUpload($pre, $fieldName, $id){
		if(Input::hasFile($fieldName)) {

			$upload_cover = Input::file($fieldName);
			//mengambil extension
			$extension = $upload_cover->getClientOriginalExtension();

			$upload_cover = Image::make($upload_cover);
			$upload_cover->resize(1000, null, function ($constraint) {
				$constraint->aspectRatio();
				$constraint->upsize();
			});

			//membuat nama file random + extension
			$filename =	 $pre . $id . '.' . $extension;

			//menyimpan bpjs_image ke folder public/img
			$destination_path = public_path() . DIRECTORY_SEPARATOR . 'img/pelamar';

			// Mengambil file yang di upload
			$upload_cover->save($destination_path . '/' . $filename);
			
			//mengisi field bpjs_image di book dengan filename yang baru dibuat
			return $filename;
			
		} else {
			return null;
		}

	}
	
	
	
}
