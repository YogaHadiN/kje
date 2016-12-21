<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Ac;
use App\Classes\Yoga;
use Input;

class AcsController extends Controller
{
	public function index(){
		$acs            = Ac::all();
		return view('acs.index', compact('acs'));
	}
	public function create(){
		return view('acs.create', compact(''));
	}
	public function store(){
		//return dd( Input::all() );
		$ac             = new Ac;
		$ac->merek      = Input::get('merek');
		$ac->keterangan = Input::get('keterangan');
		$ac->image      = $this->imageUpload('ac','image', $ac->id);
		$confirm        = $ac->save();
		if ($confirm) {
			$pesan      = Yoga::suksesFlash('AC baru'  . $ac->id . ' - ' . $ac->merek . ' <strong>BERHASIL</strong> dibuat');
		} else {
			$pesan      = Yoga::gagalFlash('AC baru'  . $ac->id . ' - ' . $ac->merek . ' <strong>GAGAL</strong> dibuat');
		}
		return redirect('acs')->withPesan($pesan);
	}
	
	public function edit($id){
		$ac = Ac::find($id);
		return view('acs.edit', compact('ac'));
	}
	
	private function imageUpload($pre, $fieldName, $id){
		if(Input::hasFile($fieldName)) {

			$upload_cover = Input::file($fieldName);
			//mengambil extension
			$extension = $upload_cover->getClientOriginalExtension();

			//membuat nama file random + extension
			$filename =	 $pre . $id . '.' . $extension;

			//menyimpan bpjs_image ke folder public/img
			$destination_path = public_path() . DIRECTORY_SEPARATOR . 'img/ac';

			// Mengambil file yang di upload
			$upload_cover->move($destination_path, $filename);
			
			//mengisi field bpjs_image di book dengan filename yang baru dibuat
			return $filename;
			
		} else {
			return null;
		}
	}
}
