<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;
use App\Models\Classes\Yoga;
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

			$query = "SELECT px.id as id, ";
			$query .= "p.nama as nama, ";
			$query .= "asu.nama as nama_asuransi, ";
			$query .= "px.tanggal as tanggal, ";
			$query .= "px.piutang as piutang, ";
			$query .= "px.piutang_dibayar as piutang_dibayar , ";
			$query .= "px.piutang_dibayar as piutang_dibayar_awal ";
			$query .= "from periksas as px ";
			$query .= "join pasiens as p on px.pasien_id = p.id ";
			$query .= "join asuransis as asu on asu.id = px.asuransi_id ";
			$query .= "where px.piutang > 0 ";
			$query .= "and px.piutang > px.piutang_dibayar ";
			$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
			$query .= "and px.asuransi_id = '{$id}' ";
			$query .= "and tanggal BETWEEN '{$awal}' and '{$akhir}' ";
			return json_encode(DB::select($query));
		} else {

			$query = "SELECT px.id as id, ";
			$query .= "p.nama as nama, ";
			$query .= "asu.nama as nama_asuransi, ";
			$query .= "px.tanggal as tanggal, ";
			$query .= "px.piutang as piutang, ";
			$query .= "px.piutang_dibayar as piutang_dibayar , ";
			$query .= "px.piutang_dibayar as piutang_dibayar_awal ";
			$query .= "from periksas as px ";
			$query .= "join pasiens as p on px.pasien_id = p.id ";
			$query .= "join asuransis as asu on asu.id = px.asuransi_id ";
			$query .= "where px.piutang > 0 ";
			$query .= "and px.piutang > px.piutang_dibayar ";
			$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
			$query .= "and px.asuransi_id = '{$id}' ";
			return json_encode(DB::select($query));
		}
	}

}
