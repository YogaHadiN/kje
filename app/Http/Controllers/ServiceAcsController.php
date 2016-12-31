<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Classes\Yoga;
use App\JurnalUmum;
use App\FakturBelanja;
use Input;
use Image;

class ServiceAcsController extends Controller
{

	public function create(){
		return view('service_acs.create', compact(''));
	}
	public function store(){

		$sa              = new ServiceAc;
		$sa->ac_id       = Input::get('ac_id');
		$sa->supplier_id = Input::get('supplier_id');
		$sa->biaya       = Yoga::clean( Input::get('biaya') );
		$sa->tanggal     = Yoga::datePrep( Input::get('tanggal') );
		$sa->image       = $this->imageUpload('sa','image', $sa->id);
		$confirm         = $sa->save();

		if ($confirm) {
			$timestamp = date('Y-m-d H:i:s');
			$data[] = [
				'jurnalable_id'   => $sa->id,
				'debit'           => 1,
				'nilai'           => $sa->biaya,
				'coa_id'          => '623433',
				'keterangan'      => 'tidak ada keterangan',
				'jurnalable_type' => 'App\ServiceAc',
				'created_at'      => $timestamp,
				'updated_at'      => $timestamp
			];

			$data[] = [
				'jurnalable_id'   => $sa->id,
				'debit'           => 0,
				'nilai'           => $sa->biaya,
				'coa_id'          => '623433',
				'keterangan'      => 'tidak ada keterangan',
				'jurnalable_type' => 'App\ServiceAc',
				'created_at'      => $timestamp,
				'updated_at'      => $timestamp
			];

			JurnalUmum::insert($data);

		}

		if ($confirm) {
			$pesan = Yoga::suksesFlash('Service AC'  . $sa->id . ' - ' . $sa->ac->merek . ' <strong>BERHASIL</strong> di lakukan ');
		} else {
			$pesan = Yoga::gagalFlash('Service AC'  . $sa->id . ' - ' . $sa->ac->merek . ' <strong>GAGAL</strong> di lakukan ');
		}

		return redirect('pengeluarans/service_acs')->withPesan($pesan);

	}
	
	private function imageUpload($pre, $fieldName, $id){
		if(Input::hasFile($fieldName)) {

			$upload_cover = Input::file($fieldName);
			//mengambil extension
			$extension = $upload_cover->getClientOriginalExtension();

			//membuat nama file random + extension
			$filename =	 $pre . $id . '.' . $extension;

			//menyimpan bpjs_image ke folder public/img
			$destination_path = public_path() . DIRECTORY_SEPARATOR . 'img/belanja/service_ac';

			// Mengambil file yang di upload
			$upload_cover->move($destination_path, $filename);
			
			//mengisi field bpjs_image di book dengan filename yang baru dibuat
			return $filename;
			
		} else {
			return null;
		}
	}
	public function show($id){
		$fakturbelanjas = FakturBelanja::find($id);
		return view('pangeluarans.service_ac.show', compact('fakturbelanjas'));
	}
	
	
}
