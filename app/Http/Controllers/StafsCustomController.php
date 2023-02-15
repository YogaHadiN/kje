<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Input;
use DB;
use App\Models\Staf;
use App\Models\BayarGaji;

class StafsCustomController extends Controller
{

	public function __construct()
	 {
		 $this->middleware('super', ['only' => ['pengantar',
			 'gaji'
		 ]]);
	 }
    public function gaji($id){
    	$gajis = BayarGaji::where('staf_id', $id)->latest()->paginate(20);
    	$staf = Staf::find($id);
		return view('stafs.gaji', compact(
			'gajis',
			'staf'
		));
    }
    public function gajiSearch(){
		$data          = $this->queryData( false);
		$count         = $this->queryData( false, true);
		$pages = ceil( $count/ Input::get('displayed_rows') );
		return [
			'data'  => $data,
			'pages' => $pages,
			'key'   => Input::get('key'),
			'rows'  => $count
		];
    }

	private function queryData(
		$include_abaikan = false,
		$count = false
	){
		$pass        = Input::get('key') * Input::get('displayed_rows');
		$query       = "SELECT ";
		if (!$count) {
			$query .= "bgj.tanggal_dibayar, ";
			$query .= "sum(bgj.gaji_pokok) as gaji_pokok, ";
			$query .= "sum(bgj.bonus) as bonus, ";
			$query .= "sum(pph.pph21) as pph21 ";
		} else {
			$query .= "count(bgj.id) as jumlah ";
		}
		$query .= "FROM bayar_gajis as bgj ";
		$query .= "JOIN pph21s as pph on pph.pph21able_id = bgj.id and pph21able_type = 'App\\\Models\\\BayarGaji' ";
		$query .= "where 0 = 0 ";
        if ( !empty( Input::get('tanggal_dibayar') ) ) {
            $query .= "AND bgj.tanggal_dibayar like '" . Input::get('tanggal_dibayar'). "%'";
        }
        if ( !empty( Input::get('gaji_pokok') ) ) {
            $query .= "AND bgj.gaji_pokok like '" . Input::get('gaji_pokok'). "%'";
        }
        if ( !empty( Input::get('bonus') ) ) {
            $query .= "AND bgj.bonus like '" . Input::get('bonus'). "%'";
        }
        if ( !empty( Input::get('pph21') ) ) {
            $query .= "AND bgj.pph21 like '" . Input::get('pph21'). "%'";
        }
		$query .= "AND bgj.staf_id = " . Input::get('staf_id') . " ";
		$query .= "AND bgj.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "GROUP BY YEAR(bgj.tanggal_dibayar), MONTH(bgj.tanggal_dibayar)";
		if (!$count) {
			$query .= " LIMIT {$pass}, " . Input::get('displayed_rows');
		}
        $query .= ";";

        if (!empty( Input::get('displayed_rows') )) {
            $query_result = DB::select($query);

            if (!$count) {
                return $query_result;
            } else {
                return $query_result[0]->jumlah;
            }
        }
	}
    

    
}
