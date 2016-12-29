<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\AntrianPeriksa;
use App\Periksa;
use App\Classes\Yoga;
use App\GambarPeriksa;
use Input;

class ImagesAntrianPeriksaController extends Controller
{
	public function create($id){
		if ( AntrianPeriksa::find( $id ) != null ) {
			if ( AntrianPeriksa::find($id)->gambars->count() > 0 ) {
				return redirect('antrianperiksa/' . $id . '/images/edit');
			}
			$antrianperiksa = AntrianPeriksa::find($id);
			return view('imagesAntrian.create', compact('antrianperiksa'));
		} else {
			$pesan = Yoga::gagalFlash('Pasien sudah tidak ada di antrian');
			return redirect()->back()->withPesan($pesan);
		}

	}
	public function store($id){
		$periksa = AntrianPeriksa::find($id);
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
						 'gambarable_type' => 'App\AntrianPeriksa',
						 'created_at' => $timestamp,
						 'updated_at' => $timestamp
					];
				}
				$confirm = GambarPeriksa::insert($data);
			}
		}

		if ($confirm) {
			$pesan = Yoga::suksesFlash('Gambar Berhasil di Masukkan');
		} else {
			$pesan = Yoga::gagalFlash('Gambar GAGAL di Update');
		}

		if ($periksa->poli == 'sks') {
			$poli = 'umum';
		} else {
			$poli = $periksa->poli;
		}
		return redirect('images/result')->withPesan($pesan);
	}
	public function edit($id){
		$antrianperiksa = AntrianPeriksa::find($id);
		if ($antrianperiksa == null) {
			$pesan = Yoga::gagalFlash('Antrian Sudah tidak ada, mungkin sudah disubmit');
			return redirect()->back()->withPesan($pesan);
		}
		return view('imagesAntrian.edit', compact(
			'antrianperiksa',
			'sisa'
		));
		
	}
	public function update($id){
		//return Input::get('image_sisa');
		$px = new Periksa;

		GambarPeriksa::where('gambarable_id', $id)
			->where('gambarable_type', 'App\AntrianPeriksa')
			->delete();

		$image_sisa = Input::get('image_sisa');
		$sisa = json_decode($image_sisa,true);

		$start_input_key = count($sisa);
		$confirm = GambarPeriksa::insert($sisa);
		if ( Input::hasFile('foto_estetika') ) {
			if (count( Input::file('foto_estetika') ) > 0 ) {
				$timestamp = date('Y-m-d H:i:s');
				$files = Input::file('foto_estetika');
				$data=[];
				foreach ($files as $k=>$file) {
					$filename = $px->imageUpload($file, $id, (int)$k + (int)$start_input_key); 
					$data[] = [
						 'nama'		  => $filename,
						 'keterangan' => Input::get('keterangan_gambar')[$k],
						 'gambarable_id' => $id,
						 'gambarable_type' => 'App\AntrianPeriksa',
						 'created_at' => $timestamp,
						 'updated_at' => $timestamp
					];
				}
				$confirm = GambarPeriksa::insert($data);
			}
		}
		if ($confirm) {
			$pesan = Yoga::suksesFlash('Update gambar periksa berhasil');
		} else {
			$pesan = Yoga::gagalFlash('Update gambar periksa gagal');
		}
		$periksa = AntrianPeriksa::find($id);
		return redirect('images/result')->withPesan($pesan);
	}
}
