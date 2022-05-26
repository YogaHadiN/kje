<?php

namespace App\Http\Controllers;

use Input;
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
		$poli_ids       = [];
		foreach ($jenis_antrian->poli_antrian as $poli) {
			$poli_ids[] = $poli->poli_id;
		}
		$antrian_periksas = AntrianPeriksa::with(
			'pasien',
			'antars',
			'antrian.jenis_antrian',
		   	'staf',
		   	'asuransi'
		)->whereIn('poli', $poli_ids)
			->get();
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

