<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;
use App\Classes\Yoga;
use DB;

class LaporansAjaxController extends Controller
{

	public function filter(){
		$awal = Input::get('awal');
		$akhir = Input::get('akhir');
		$id = Input::get('id');
		
		if ( $awal != '' && $akhir != '') {
			

			$awal = Yoga::datePrep($awal);
			$akhir = Yoga::datePrep($akhir);

			$query = "SELECT px.id as id, p.nama as nama, asu.nama as nama_asuransi, px.tanggal as tanggal, px.piutang as piutang, px.piutang_dibayar as piutang_dibayar , px.piutang_dibayar as piutang_dibayar_awal from periksas as px join pasiens as p on px.pasien_id = p.id join asuransis as asu on asu.id = px.asuransi_id where px.piutang > 0 and px.piutang > px.piutang_dibayar and px.asuransi_id = '{$id}' and tanggal BETWEEN '{$awal}' and '{$akhir}';";
			return json_encode(DB::select($query));
		} else {

			$query = "SELECT px.id as id, p.nama as nama, asu.nama as nama_asuransi, px.tanggal as tanggal, px.piutang as piutang, px.piutang_dibayar as piutang_dibayar , px.piutang_dibayar as piutang_dibayar_awal from periksas as px join pasiens as p on px.pasien_id = p.id join asuransis as asu on asu.id = px.asuransi_id where px.piutang > 0 and px.piutang > px.piutang_dibayar and px.asuransi_id = '{$id}';";
			return json_encode(DB::select($query));
		}
	}

}
