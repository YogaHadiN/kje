<?php

namespace App\Http\Controllers;

use Input;
use DB;
use App\Http\Requests;
use App\Models\Asuransi;
use App\Models\Tarif;
use App\Models\BayarDokter;
use App\Models\Classes\Yoga;

class BayarDoktersController extends Controller
{
    public function index(){
        return view('bayar_dokters.index');
    }
    public function selectAjax(){
		$pembayaran     = Input::get('pembayaran');
		$tanggal        = Input::get('tanggal');
		$nama_dokter    = Input::get('nama_dokter');
		$displayed_rows = Input::get('displayed_rows');
		$key            = Input::get('key');

		$pembayaran = preg_replace('/[^0-9]/', '',$pembayaran);

		$pass = $key * $displayed_rows;

		$datas = $this->queryData($pembayaran, $tanggal, $nama_dokter, $pass, $displayed_rows);
		$count = $this->queryData($pembayaran, $tanggal, $nama_dokter, $pass, $displayed_rows, true);

		$count = $count[0]->jumlah;

		$pages = ceil( $count / $displayed_rows );

		return [
			'rows' => $count,
			'data' => $datas,
			'pages' => $pages,
			'key' => $key
		];
    }

    /**
     * undocumented function
     *
     * @return void
     */
    private function queryData($pembayaran, $tanggal, $nama_dokter, $pass, $displayed_rows, $count = false)
    {

        $query  = "SELECT ";
		if (!$count) {
            $query .= "bgj.id as id, ";
            $query .= "stf.nama as nama_dokter, ";
            $query .= "bgj.tanggal_dibayar as tanggal, ";
            $query .= "bgj.gaji_pokok + bgj.bonus as pembayaran, ";
            $query .= "DATE_FORMAT(bgj.created_at, '%Y-%m-%d') as created_at ";
		} else {
			$query .= "count(bgj.id) as jumlah ";
		}
        $query .= "FROM bayar_gajis as bgj ";
        $query .= "JOIN stafs as stf on stf.id = bgj.staf_id ";
        $query .= "WHERE ";
        $query .= "titel = 'dr' ";
		$query .= "AND (bgj.gaji_pokok + bgj.bonus like ? or ? = '') ";
		$query .= "AND (bgj.tanggal_dibayar like ? or ? = '') ";
		$query .= "AND (stf.nama like ? or ? = '') ";
        $query .= "ORDER BY bgj.id DESC ";
		if (!$count) {
			$query .= "LIMIT {$pass}, {$displayed_rows} ";
		}	
		$data = DB::select($query, [
			 $pembayaran . '%',
			$pembayaran ,
			'%' . $tanggal . '%',
			$tanggal ,
			'%' . $nama_dokter . '%',
			$nama_dokter 
		]);
		return $data;
    }
    
}
