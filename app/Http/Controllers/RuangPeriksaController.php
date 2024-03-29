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

	public function __construct(){
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

		$query  = "SELECT ";
		$query .= "po.poli as poli, ";
		$query .= "apx.id as antrian_periksa_id, ";
		$query .= "po.id as poli_id, ";
		$query .= "apx.asuransi_id as asuransi_id, ";
		$query .= "jnt.prefix as prefix, ";
		$query .= "asu.nama as nama_asuransi, ";
		$query .= "asu.tipe_asuransi_id as tipe_asuransi_id, ";
		$query .= "psn.id as pasien_id, ";
		$query .= "count(pgn.id) as jumlah_pengantar, ";
		$query .= "psn.nama as nama_pasien, ";
		$query .= "apx.staf_id as staf_id, ";
		$query .= "ant.created_at as created_at, ";
		$query .= "ant.antriable_type as antriable_type, ";
		$query .= "ant.id as antrian_id, ";
		$query .= "ant.antriable_id as antriable_id, ";
		$query .= "apx.tanggal as tanggal, ";
		$query .= "apx.jam as jam, ";
		$query .= "apx.id as id, ";
		$query .= "ant.nomor as nomor_antrian, ";
		$query .= "ant.antriable_type as antriable_type, ";
		$query .= "prx.antrian_periksa_id as periksa_id ";
		$query .= " FROM antrian_periksas as apx ";
		$query .= "LEFT JOIN periksas as prx on prx.antrian_periksa_id = apx.id ";
		$query .= "JOIN pasiens as psn on psn.id = apx.pasien_id ";
		$query .= "LEFT JOIN pengantar_pasiens as pgn on pgn.pengantar_id = psn.id ";
		$query .= "LEFT OUTER JOIN antrians as ant on ant.antriable_id = apx.id AND ant.antriable_type = 'App\\\Models\\\AntrianPeriksa' ";
		$query .= "LEFT JOIN jenis_antrians as jnt on jnt.id = ant.jenis_antrian_id ";
		$query .= "JOIN stafs as stf on stf.id = apx.staf_id ";
		$query .= "JOIN polis as po on po.id = apx.poli_id ";
		$query .= "JOIN asuransis as asu on asu.id = apx.asuransi_id ";
        $query .= "WHERE ";
        $query .= "(ant.antriable_type = 'App\\\Models\\\AntrianPeriksa' or ant.antriable_type is null) ";
        $query .= "AND ";
        $query .= "apx.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "AND ";
        $query .= "apx.poli_id in ({$poli_ids}) ";
		$query .= "GROUP BY apx.id ";
		$query .= "ORDER BY ant.id ASC ";


        /* dd( $query ); */
		$antrian_periksas = DB::select($query);

		/* dd( $antrian_periksas ); */



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

		/* foreach ($antrian_kasirs as $an) { */
		/* 	$asuransi = $an->periksa->asuransi->nama; */
		/* } */

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

        /* dd( $antrian_apoteks ); */

		/* foreach ($antrian_apoteks as $an) { */
		/* 	$asuransi = $an->periksa->asuransi->nama; */
		/* } */

		$poli      = 'umum';
		$staf_list = Yoga::stafList();
		$poli_list = Poli::pluck('poli', 'id');
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

