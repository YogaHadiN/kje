<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Periksa;
use App\Classes\Yoga;
use App\GambarPeriksa;
use Input;

class ImagesController extends Controller
{
	public function create($id){
		$periksa = Periksa::find($id);
		return view('images.create', compact('periksa'));
	}
	public function store($id){
		$periksa = Periksa::find($id);
		$confirm = false;
		$px = new Periksa;
		if ( Input::hasFile('foto_estetika') ) {
			if (count( Input::file('foto_estetika') ) > 0 ) {
				$timestamp = date('Y-m-d H:i:s');
				$files = Input::file('foto_estetika');
				foreach ($files as $k=>$file) {
					$filename = $px->imageUpload($file, $id, $k); 
					$data[] = [
						 'nama'		  => $filename,
						 'keterangan' => Input::get('keterangan_gambar')[$k],
						 'periksa_id' => $id,
						 'created_at' => $timestamp,
						 'updated_at' => $timestamp
					];
				}
				$confirm = GambarPeriksa::insert($data);
			}
		}

		if ($confirm) {
			$pesan = Yoga::suksesFlash('Gambar Berhasil di Update');
		} else {
			$pesan = Yoga::gagalFlash('Gambar GAGAL di Update');
		}

		return redirect('ruangperiksa/estetika')->withPesan($pesan);
	}
	public function edit($id){
		$periksa = Periksa::find($id);
		return view('images.edit', compact('periksa'));
		
	}
	
	
	
}
