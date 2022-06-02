<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Storage;
use App\Models\Invoice;
use App\Models\Asuransi;
use App\Models\Classes\Yoga;
use Input;

class InvoiceController extends Controller
{
	public function index(){
		return view('invoices.index', [
			'asuransi_list' => Asuransi::list()
		]);
	}

	public function getData(){
		$asuransi_id   = Input::get('$asuransi_id');
		$tanggal       = Input::get('tanggal');
		$piutang       = Input::get('piutang');
		$sudah_dibayar = Input::get('sudah_dibayar');
		$sisa          = Input::get('sisa');
		$invoice_id    = Input::get('invoice_id');

		$query  = "SELECT ";
		$query .= "inv.id as invoice_id, ";
		$query .= "asu.nama as nama_asuransi, ";
		$query .= "kbs.tanggal as tanggal, ";
		$query .= "sum(prx.piutang) as piutang, ";
		$query .= "COALESCE(sum(pdb.pembayaran),0) as sudah_dibayar ";
		$query .= "FROM invoices as inv ";
		$query .= "JOIN kirim_berkas as kbs on kbs.id = inv.kirim_berkas_id ";
		$query .= "JOIN periksas as prx on prx.invoice_id = inv.id ";
		$query .= "JOIN asuransis as asu on asu.id = prx.asuransi_id ";
		$query .= "LEFT JOIN piutang_dibayars as pdb on pdb.periksa_id = prx.id ";
		$query .= "WHERE '' = '' ";
		if (!empty($asuransi_id)) {
			$query .= "AND prx.asuransi_id = '{$asuransi_id}%' ";
		}
		if (!empty($tanggal)) {
			$query .= "AND kbs.tanggal like '{$tanggal}%' ";
		}
		if (!empty($invoice_id)) {
			$query .= "AND inv.id like '%{$invoice_id}%' ";
		}
		$query .= "GROUP BY prx.invoice_id ";
		$query .= "HAVING '' = '' ";
		if (!empty($piutang)) {
			$query .= "AND CAST(piutang as CHAR) LIKE '{$piutang}%' ";
		}
		if (!empty($sudah_dibayar)) {
			$query .= "AND CAST(sudah_dibayar as CHAR) LIKE '{$sudah_dibayar}%' ";
		}
		if (!empty($sisa)) {
			$query .= "AND CAST(piutang - sudah_dibayar as CHAR) LIKE '{$sisa}%' ";
		}
		$query .= "ORDER BY kbs.tanggal desc ";
		$query .= "LIMIT 0, 20";
		/* dd( $query ); */
		return DB::select($query);
	}
	
	
	public function show($id){
		$id       = str_replace('!', '/', $id);
		$invoice  = Invoice::with(
			'periksa.asuransi', 
			'periksa.pasien', 
			'periksa.pembayarans'
		)->where('id', $id )->first();
		return view('invoices.show', compact(
			'invoice'
		));
	}
	public function upload_verivication($id){
		$messages = [
			'required' => ':attribute Harus Diisi',
		];
		$rules = [
			'received_verification' => 'required|image'
		];

		$validator = \Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$search_id = str_replace('!', '/',  $id);

		$invoice                        = Invoice::find($search_id);
		$invoice->received_verification = $this->imageUpload('invoice', 'received_verification', $id);
		$invoice->save();

		$pesan = Yoga::suksesFlash('Validasi Penerimaan Berkas Berhasil di Upload');
		return redirect('invoices/pendingReceivedVerification')->withPesan($pesan);
		
	}

	private function imageUpload($pre, $fieldName, $id){
		if(Input::hasFile($fieldName)) {

			$upload_cover = Input::file($fieldName);
			/* dd( $upload_cover ); */
			//mengambil extension
			$extension = $upload_cover->getClientOriginalExtension();

			/* $upload_cover = Image::make($upload_cover); */
			/* $upload_cover->resize(1000, null, function ($constraint) { */
			/* 	$constraint->aspectRatio(); */
			/* 	$constraint->upsize(); */
			/* }); */

			//membuat nama file random + extension
			$filename =	 $pre . $id . '_' .  time().'.' . $extension;

			//menyimpan bpjs_image ke folder public/img
			$destination_path =  'img/invoices/verification/';

			$filename = $destination_path . $filename;

			//destinasi s3
			//
			Storage::disk('s3')->put( $filename, file_get_contents($upload_cover));
			// Mengambil file yang di upload

			/* $upload_cover->save($destination_path . '/' . $filename); */
			
			//mengisi field bpjs_image di book dengan filename yang baru dibuat
			return $filename;
			
		} else {
			return null;
		}
	}
	public function pendingReceivedVerification(){
		return view('invoices.pending', [
			'pending' => $this->queryPendingReceivedVerification()
		]);

	}
	public function queryPendingReceivedVerification(){
		$query  = "SELECT ";
		$query .= "inv.id as invoice_id, ";
		$query .= "inv.created_at as created_at, ";
		$query .= "inv.created_at as tanggal, ";
		$query .= "asu.nama as nama_asuransi ";
		$query .= "FROM invoices as inv ";
		$query .= "JOIN periksas as prx on prx.invoice_id = inv.id ";
		$query .= "JOIN asuransis as asu on asu.id = prx.asuransi_id ";
		$query .= "WHERE asu.tipe_asuransi = 3 ";
		$query .= "AND inv.created_at > '" . date('Y-m', strtotime("-5 months", strtotime("NOW"))) . "-01 00:00:00' " ;
		$query .= "AND ( inv.received_verification is null or inv.received_verification = '' ) ";
		$query .= "AND inv.pembayaran_asuransi_id is null ";
		$query .= "GROUP BY inv.id ";
		$query .= "ORDER BY inv.created_at desc ";
		return DB::select($query);
	}
}
