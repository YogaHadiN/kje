<?php

namespace App\Http\Controllers;

use Input;
use DB;
use Illuminate\Http\Request;
use App\Models\AntrianPeriksa;
use App\Models\JenisAntrian;
use App\Models\AntrianKasir;
use App\Models\AntrianApotek;
use App\Models\Classes\Yoga;
use App\Models\Periksa;
use App\Models\Poli;
use Endroid\QrCode\QrCode;

class RuangPeriksaController extends Controller
{
	protected $staf_list;
	private $poli_list;
	public function __construct(){
		$this->staf_list = Yoga::stafList();
		$this->poli_list = Poli::pluck('poli', 'id')->all();
        $this->middleware('backIfNotFound', ['only' => ['index']]);
	}

	public function index(Request $request, $jenis_antrian_id){
		$jenis_antrian  = $request->jenis_antrian;
		$poli_ids       = '';
		foreach ($jenis_antrian->poli_antrian as $k=> $poli) {
			if ($k > 0) {
				$poli_ids .= ',';
			}
			$poli_ids .=  "'" .$poli->poli_id. "'";
		}

		/* dd( $poli_ids ); */
		$query  = "SELECT ";
		$query .= "apx.poli as poli, ";
		$query .= "apx.asuransi_id as asuransi_id, ";
		$query .= "jnt.prefix as prefix, ";
		$query .= "asu.nama as nama_asuransi, ";
		$query .= "psn.id as pasien_id, ";
		$query .= "count(pgn.id) as jumlah_pengantar, ";
		$query .= "psn.nama as nama_pasien, ";
		$query .= "apx.staf_id as staf_id, ";
		$query .= "ant.created_at as created_at, ";
		$query .= "ant.id as antrian_id, ";
		$query .= "apx.tanggal as tanggal, ";
		$query .= "apx.jam as jam, ";
		$query .= "apx.id as id, ";
		$query .= "ant.nomor as nomor_antrian, ";
		$query .= "prx.antrian_periksa_id as periksa_id ";
		$query .= " FROM antrian_periksas as apx ";
		$query .= "LEFT JOIN periksas as prx on prx.antrian_periksa_id = apx.id ";
		$query .= "JOIN pasiens as psn on psn.id = apx.pasien_id ";
		$query .= "LEFT JOIN pengantar_pasiens as pgn on pgn.pengantar_id = psn.id ";
		$query .= "LEFT JOIN antrians as ant on ant.antriable_id = apx.id ";
		$query .= "JOIN jenis_antrians as jnt on jnt.id = ant.jenis_antrian_id ";
		$query .= "JOIN stafs as stf on stf.id = apx.staf_id ";
		$query .= "JOIN asuransis as asu on asu.id = apx.asuransi_id ";
		/* $query .= "WHERE ant.antriable_type = 'App\\\Models\\\AntrianPeriksa' "; */
		$query .= "WHERE apx.poli in ({$poli_ids})";
		/* $query .= "AND apx.poli in ({$poli_ids})"; */
		$query .= "GROUP BY apx.id ASC ";
		$query .= "ORDER BY ant.id ";
		$antrian_periksas = DB::select($query);



		/* $antrian_periksas = AntrianPeriksa::with( */
		/* 	'pasien', */
		/* 	'antars', */
		/* 	'antrian.jenis_antrian', */
		/*    	'staf', */
		/*    	'asuransi' */
		/* )->whereIn('poli', $poli_ids) */
		/* 	->get(); */
		$antrian_kasirs  = AntrianKasir::with(
			'periksa.pasien',
			'periksa.suratSakit',
			'periksa.staf',
			'periksa.kontrol',
			'periksa.asuransi',
			'periksa.rujukan.tujuanRujuk',
			'antars',
			'antrian.jenis_antrian'
		)->get();
		$antrian_apoteks = AntrianApotek::with(
			'periksa.pasien',
			'periksa.staf',
			'periksa.suratSakit',
			'periksa.kontrol',
			'periksa.asuransi',
			'periksa.rujukan.tujuanRujuk',
			'antars',
			'antrian.jenis_antrian'
		)->get();
		$poli      = 'umum';
		$staf_list = $this->staf_list;
		$poli_list = $this->poli_list;
		return view('antrianperiksas.index', compact(
			'antrian_periksas',
			'antrian_kasirs',
			'antrian_apoteks',
			'staf_list',
			'poli',
			'poli_list'
		));
	}
	public function ruangan(){
		\Session::put('ruangan', Input::get('ruangan'));
		return \Session::get('ruangan');
	}
}

