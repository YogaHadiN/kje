<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Input;
use DB;
use App\JurnalUmum;
use App\Coa;
use App\Classes\Yoga;

class LaporanNeracasController extends Controller
{

    public function index(){
		$akunAktivaLancar      = $this->temp()['akunAktivaLancar'];
		$total_harta           = $this->temp()['total_harta'];
		$akunHutang            = $this->temp()['akunHutang'];
		$akunModal             = $this->temp()['akunModal'];
		$laba_tahun_berjalan   = $this->temp()['laba_tahun_berjalan'];
		$akunAktivaTidakLancar = $this->temp()['akunAktivaTidakLancar'];

    	return view('laporan_neracas.show', compact(
            'akunAktivaLancar',
            'total_harta',
            'akunHutang',
            'akunModal',
            'laba_tahun_berjalan',
            'akunAktivaTidakLancar'
        ));
	}
	public function temp(){
		
		$akunAktivaLancar = Coa::where('kelompok_coa_id', 'like', '11')->get();
		$akunAktivaTidakLancar = Coa::where('kelompok_coa_id', 'like', '12')->get();
		$total_harta = 0;
		foreach ($akunAktivaLancar as $v) {
			$total_harta += $v->total;
		}
		$akunHutang = Coa::where('kelompok_coa_id', 'like', '2')->get();
		$total_hutang = 0;
		foreach ($akunHutang as $v) {
			$total_hutang += $v->total;
		}
		$akunModal = Coa::where('kelompok_coa_id', 'like', '3')->get();
		$total_modal = 0;
		foreach ($akunModal as $v) {
			$total_modal += $v->total;
		}
		$laba_tahun_berjalan = $total_harta - $total_hutang - $total_modal;
		return [ 
			'akunAktivaLancar'      => $akunAktivaLancar,
			'total_harta'           => $total_harta,
			'akunHutang'            => $akunHutang,
			'akunModal'             => $akunModal,
			'laba_tahun_berjalan'   => $laba_tahun_berjalan,
			'akunAktivaTidakLancar' => $akunAktivaTidakLancar
		];
	}
	

}
