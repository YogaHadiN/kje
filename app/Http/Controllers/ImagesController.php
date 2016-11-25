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
		if ( Periksa::find($id)->gambars->count() > 0 ) {
			return redirect('periksa/' . $id . '/images/edit');
		}
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
						 'gambarable_id' => $id,
						 'gambarable_type' => 'App\Periksa',
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

		return redirect('images/result')->withPesan($pesan);

	}
	public function edit($id){
		$periksa = Periksa::find($id);

		return view('images.edit', compact(
			'periksa',
			'sisa'
		));
		
	}
	public function update($id){
		$px = new Periksa;
		GambarPeriksa::where('gambarable_id', $id)
						->where('gambarable_type', 'App\Periksa')
						->delete();

		$image_sisa = Input::get('image_sisa');
		$sisa = json_decode($image_sisa,true);
		//return dd( $sisa );
		$start_input_key = count($sisa);
		$confirm = GambarPeriksa::insert($sisa);

		//return  dd(Input::file('foto_estetika')) ;

		if ( Input::hasFile('foto_estetika') ) {
			if (count( Input::file('foto_estetika') ) > 0 ) {
				$timestamp = date('Y-m-d H:i:s');
				$files = Input::file('foto_estetika');
				foreach ($files as $k=>$file) {
					$filename = $px->imageUpload($file, $id, (int)$k + (int)$start_input_key); 
					$data[] = [
						 'nama'		  => $filename,
						 'keterangan' => Input::get('keterangan_gambar')[$k],
						 'gambarable_id' => $id,
						 'gambarable_type' => 'App\Periksa',
						 'created_at' => $timestamp,
						 'updated_at' => $timestamp
					];
				}
				//return $data;
				$confirm = GambarPeriksa::insert($data);
			}
		}
		if ($confirm) {
			$pesan = Yoga::suksesFlash('Update gambar periksa berhasil');
		} else {
			$pesan = Yoga::gagalFlash('Update gambar periksa gagal');
		}
		$periksa = Periksa::find($id);
		return redirect('images/result')->withPesan($pesan);
	}
	public function result(){
		return view('images.result', compact(''));
	}
	
}
