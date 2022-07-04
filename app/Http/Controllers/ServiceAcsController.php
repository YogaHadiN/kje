<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Classes\Yoga;
use App\Models\JurnalUmum;
use App\Models\FakturBelanja;
use Input;
use Image;
use Storage;

class ServiceAcsController extends Controller
{

	public function create(){
		return view('service_acs.create');
	}
	public function store(){

		$sa              = new ServiceAc;
		$sa->ac_id       = Input::get('ac_id');
		$sa->supplier_id = Input::get('supplier_id');
		$sa->biaya       = Yoga::clean( Input::get('biaya') );
		$sa->tanggal     = Yoga::datePrep( Input::get('tanggal') );
		$sa->image       = $this->imageUpload('sa','image', $sa->id);
		$confirm         = $sa->save();

		$coa_id_623433 = Coa::where('kode_coa', '623433')->first()->id;
		if ($confirm) {
			$timestamp = date('Y-m-d H:i:s');
			$data[] = [
				'jurnalable_id'   => $sa->id,
				'debit'           => 1,
				'nilai'           => $sa->biaya,
				'coa_id'          => $coa_id_623433,
				'keterangan'      => 'tidak ada keterangan',
				'jurnalable_type' => 'App\Models\ServiceAc',
							'tenant_id'  => session()->get('tenant_id'),
				'created_at'      => $timestamp,
				'updated_at'      => $timestamp
			];

			$data[] = [
				'jurnalable_id'   => $sa->id,
				'debit'           => 0,
				'nilai'           => $sa->biaya,
				'coa_id'          => $coa_id_623433,
				'keterangan'      => 'tidak ada keterangan',
				'jurnalable_type' => 'App\Models\ServiceAc',
							'tenant_id'  => session()->get('tenant_id'),
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
			$filename =	 $pre . $id . '_' . time() . '.' . $extension;

			//menyimpan bpjs_image ke folder public/img
			$destination_path =  'img/belanja/service_ac/';
			/* $destination_path = public_path() . DIRECTORY_SEPARATOR . 'img/belanja/service_ac/'; */

			// Mengambil file yang di upload
			/* $upload_cover->move($destination_path, $filename); */
			
			Storage::disk('s3')->put($destination_path. $filename, file_get_contents($upload_cover));
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
