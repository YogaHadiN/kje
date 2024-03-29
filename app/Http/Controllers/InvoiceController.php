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
		$asuransi_id   = Input::get('asuransi_id');
		$tanggal       = Input::get('tanggal');
		$piutang       = Input::get('piutang');
		$sudah_dibayar = Input::get('sudah_dibayar');
		$sisa          = Input::get('sisa');
		$kode_invoice  = Input::get('kode_invoice');

		$query  = "SELECT ";
		$query .= "id, ";
		$query .= "kode_invoice, ";
		$query .= "nama_asuransi, ";
		$query .= "tanggal, ";
		$query .= "sum(piutang) as total_piutang, ";
		$query .= "sum(sudah_dibayar) as total_sudah_dibayar ";
		$query .= "FROM ";
		$query .= "(";
		$query .= "SELECT ";
		$query .= "inv.id as id, ";
		$query .= "inv.kode_invoice as kode_invoice, ";
		$query .= "asu.nama as nama_asuransi, ";
		$query .= "kbs.tanggal as tanggal, ";
		$query .= "prx.piutang as piutang, ";
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
		if (!empty($kode_invoice)) {
			$query .= "AND inv.kode_invoice like '%{$kode_invoice}%' ";
		}
		$query .= "AND inv.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "GROUP BY prx.id ";
		$query .= ") as bl ";
		$query .= "GROUP BY kode_invoice ";
		$query .= "HAVING '' = '' ";
		if (!empty($piutang)) {
			$query .= "AND CAST(total_piutang as CHAR) LIKE '{$piutang}%' ";
		}
		if (!empty($sudah_dibayar)) {
			$query .= "AND CAST(total_sudah_dibayar as CHAR) LIKE '{$sudah_dibayar}%' ";
		}
		if (!empty($sisa)) {
			$query .= "AND CAST(total_piutang - total_sudah_dibayar as CHAR) LIKE '{$sisa}%' ";
		}
		$query .= "ORDER BY tanggal desc ";
		$query .= "LIMIT 0, 20";

		return DB::select($query);
	}
	
	
	public function show($id){
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
			'received_verification' => 'required|mimes:zip'
		];

		$validator = \Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$invoice                        = Invoice::find($id);
		$invoice->received_verification = $this->imageUpload('invoice', 'received_verification', $id);
		$invoice->save();

		$pesan = Yoga::suksesFlash('Validasi Penerimaan Berkas Berhasil di Upload');
		return redirect()->back()->withPesan($pesan);
		
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
		$query .= "invoice_id, ";
		$query .= "created_at, ";
		$query .= "tanggal, ";
		$query .= "sum(piutang) as total_piutang, ";
		$query .= "sum(pembayaran) as total_pembayaran, ";
		$query .= "nama_asuransi ";
		$query .= "FROM ";
		$query .= "(";
		$query .= "SELECT ";
		$query .= "inv.id as invoice_id, ";
		$query .= "inv.created_at as created_at, ";
		$query .= "krb.tanggal as tanggal, ";
		$query .= "prx.piutang as piutang, ";
		$query .= "COALESCE(sum(pdb.pembayaran),0) as pembayaran, ";
		$query .= "asu.nama as nama_asuransi ";
		$query .= "FROM invoices as inv ";
		$query .= "JOIN periksas as prx on prx.invoice_id = inv.id ";
		$query .= "LEFT JOIN piutang_dibayars as pdb on pdb.periksa_id = prx.id ";
		$query .= "JOIN asuransis as asu on asu.id = prx.asuransi_id ";
		$query .= "JOIN kirim_berkas as krb on krb.id = inv.kirim_berkas_id ";
		$query .= "WHERE asu.tipe_asuransi_id = 3 ";
		$query .= "AND krb.tanggal >= '" . date('Y-m-01', strtotime("-5 months", strtotime("NOW"))) . "' " ;
        $session = !is_null(session()->get('tenant_id')) ? session()->get('tenant_id') : 1;
		$query .= "AND inv.tenant_id = " . $session . " ";
		$query .= "AND ( inv.received_verification is null or inv.received_verification = '' ) ";
		$query .= "AND asu.id not in (";
		$query .= "151";
		$query .= ")";
		/* $query .= "AND inv.id = 'INV/1/KJE/P187/II/2022' "; */
		$query .= "GROUP BY prx.id ";
		$query .= ") as bl ";
		$query .= "GROUP BY invoice_id ";
		$query .= "HAVING sum( piutang ) - sum( pembayaran ) > 0 ";
		$query .= "ORDER BY created_at asc ";
		/* dd( DB::select($query) ); */
		return DB::select($query);
	}
}
