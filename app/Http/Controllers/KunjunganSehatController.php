<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use DB;

class KunjunganSehatController extends Controller
{
	public $input_nama;
	public $input_tanggal;
	public $input_nomor_asuransi_bpjs;
	public $input_no_telp;
	public $input_displayed_rows;
	public $input_key;
	public $input_bulan;
	public $input_tahun;
	/**
	* @param 
	*/
	public function __construct()
	{
		$this->input_nama                = Input::get('nama');
		$this->input_tanggal             = Input::get('tanggal');
		$this->input_nomor_asuransi_bpjs = Input::get('nomor_asuransi_bpjs');
		$this->input_no_telp             = Input::get('no_telp');
		$this->input_displayed_rows      = Input::get('displayed_rows');
		$this->input_key                 = Input::get('key');
	}
	
	public function searchAjax(){
		$data                = $this->queryData();
		$count               = $this->queryData(true)[0]->jumlah;
		$pages               = ceil( $count/ $this->input_displayed_rows );

		/* dd('oye'); */
		return [
			'data'  => $data,
			'pages' => $pages,
			'key'   => $this->input_key,
			'rows'  => $count
		];
	}
	public function queryData($count = false){
		$pass = $this->input_key * $this->input_displayed_rows;
		if ( isset( $this->input_tahun ) && isset( $this->input_bulan ) ) {
			$bulan_ini = $this->input_tahun . '-' . $this->input_bulan;
		}
		$query  = "SELECT ";
		if (!$count) {
			$query .= "nama, ";
			$query .= "nomor_asuransi_bpjs,";
			$query .= "no_telp,";
			$query .= "ps.id as id,";
			$query .= "pp.created_at as tanggal ";
		} else {
			$query .= "count(pp.id) as jumlah ";
		}
		$query .= "FROM pengantar_pasiens as pp ";
		$query .= "JOIN pasiens as ps on ps.id = pp.pengantar_id ";
		$query .= "WHERE ";
		$query .= "(pp.updated_at like '%{$this->input_tanggal}%') ";
		$query .= "AND (nama like '%{$this->input_nama}%') ";
		$query .= "AND (no_telp like '%{$this->input_no_telp}%') ";
		$query .= "AND (nomor_asuransi_bpjs like '%{$this->input_nomor_asuransi_bpjs}%') ";
		if (isset( $bulan_ini )) {
			$query .= "AND (pp.created_at like '{$bulan_ini}%')  ";
		}
		$query .= "AND (pcare_submit = '1') ";

		/* dd($query); */
		if (!$count) {
			$query .= "LIMIT {$pass}, {$this->input_displayed_rows} ";
		}
		/* dd( $query ); */
		return DB::select($query);
	}
}
