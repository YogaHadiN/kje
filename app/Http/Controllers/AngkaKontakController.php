<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Input;
use DB;

class AngkaKontakController extends Controller
{

	public $input_nama;
	public $input_tanggal;
	public $input_nomor_asuransi_bpjs;
	public $input_no_telp;
	public $input_displayed_rows;
	public $input_key;
	public $input_tahun;
	public $input_bulan;

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
		$this->input_tahun               = Input::get('tahun');
		$this->input_bulan               = Input::get('bulan');
	}
	
	public function searchAjax(){
		$data                = $this->queryData();
		$count               = $this->queryData(true)[0]->jumlah;
		$pages               = ceil( $count/ $this->input_displayed_rows );

		return [
			'data'  => $data,
			'pages' => $pages,
			'key'   => $this->input_key,
			'rows'  => $count
		];
	}
	public function queryData($count = false){

		$bulan_ini = $this->input_tahun . '-' . $this->input_bulan;
		$pass      = $this->input_key * $this->input_displayed_rows;
		$query = "SELECT ";
		if (!$count) {
			$query .= "ps.nama, ";
			$query .= "ps.nomor_asuransi_bpjs,";
			$query .= "ps.id,";
			$query .= "ps.no_telp,";
			$query .= "px.tanggal as tanggal ";
		} else {
			$query .= "count(*) as jumlah ";
		}

		if ($count) {
			$query .= "FROM (select ps.id ";
		}
		$query .= "FROM periksas as px ";
		$query .= "JOIN pasiens as ps on ps.id = px.pasien_id ";
		$query .= "WHERE ";
		$query .= "(px.tanggal like '%{$this->input_tanggal}%') ";
		$query .= "AND (ps.nama like '%{$this->input_nama}%') ";
		$query .= "AND (ps.no_telp like '%{$this->input_no_telp}%') ";
		$query .= "AND (ps.nomor_asuransi_bpjs like '%{$this->input_nomor_asuransi_bpjs}%') ";
		$query .= "AND (px.asuransi_id = 32) ";
		$query .= "AND (px.tanggal like '{$bulan_ini}%')  ";
		if ($count) {
			$query .= ") a ";
		}
		/* $query .= "GROUP BY px.pasien_id "; */
		/* $query .= "GROUP BY p.id "; */
		/* $query .= "ORDER BY dg.created_at DESC "; */

		if (!$count) {
			$query .= "LIMIT {$pass}, {$this->input_displayed_rows} ";
		}
		return DB::select($query);
	}
}
