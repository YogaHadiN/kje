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
		return view('laporan_neracas.index');
	}
    public function show(){
		$tahun = Input::get('tahun');
		$akunAktivaLancar      = $this->temp($tahun)['akunAktivaLancar'];
		$total_harta           = $this->temp($tahun)['total_harta'];
		$akunHutang            = $this->temp($tahun)['akunHutang'];
		$akunModal             = $this->temp($tahun)['akunModal'];
		$total_liabilitas      = $this->temp($tahun)['total_liabilitas'];
		$laba_tahun_berjalan   = $this->temp($tahun)['laba_tahun_berjalan'];
		$akunAktivaTidakLancar = $this->temp($tahun)['akunAktivaTidakLancar'];
		$labaSebelumnya        = $this->temp($tahun)['labaSebelumnya'];
		$total_modal        = $this->temp($tahun)['total_modal'];
		$total_hutang        = $this->temp($tahun)['total_hutang'];

    	return view('laporan_neracas.show', compact(
            'akunAktivaLancar',
            'tahun',
            'total_harta',
            'total_modal',
            'total_hutang',
            'total_liabilitas',
            'akunHutang',
            'labaSebelumnya',
            'akunModal',
            'laba_tahun_berjalan',
            'akunAktivaTidakLancar'
        ));
	}
	private function temp($tahun){

		$tahun_depan = $tahun + 1;

		$query = "SELECT co.id as coa_id, ";
		$query .= "co.coa, ";
		$query .= "sum(CASE WHEN debit = 1 THEN nilai ELSE 0 END) as debit, ";
		$query .= "sum(CASE WHEN debit = 0 THEN nilai ELSE 0 END) as kredit, ";
		$query .= "co.kelompok_coa_id ";
		$query .= "FROM jurnal_umums as ju ";
		$query .= "join coas as co on co.id = ju.coa_id ";
		$query .= "where ( ";
		$query .= "co.kelompok_coa_id = 11 ";
		$query .= "or co.kelompok_coa_id = 12 ";
		$query .= "or co.kelompok_coa_id = 2 ";
		$query .= "or co.kelompok_coa_id = 3 ";
		$query .= ") ";
		$query .= "and ju.created_at < '{$tahun_depan}-01-01' group by co.id";

		//return $query;
		$dataAll = DB::select($query);
		
		

		 $akunAktivaLancar = [];
		 $akunAktivaTidakLancar = [];
		 $akunHutang = [];
		 $seluruhModal = [];

		 foreach ($dataAll as $d) {
			if ($d->kelompok_coa_id == 11){
		 		$akunAktivaLancar[] = $d;
			} else if ($d->kelompok_coa_id == 12){
		 		$akunAktivaTidakLancar[] = $d;
			} else if ($d->kelompok_coa_id == 2){
		 		$akunHutang[] = $d;
			} else if ($d->kelompok_coa_id == 3){
		 		$seluruhModal[] = $d;
			}
		 }

		$total_harta = 0;
		foreach ($akunAktivaLancar as $v) {
			$total_harta += $v->debit - $v->kredit;
		}
		foreach ($akunAktivaTidakLancar as $v) {
			$total_harta += $v->debit - $v->kredit;
		}
		$total_hutang = 0;
		foreach ($akunHutang as $v) {
			$total_hutang += $v->kredit - $v->debit;
		}

		//total modal = seluruh modal + laba tahun sebelumnya

		$totalSeluruhModal = 0;
		foreach ($seluruhModal as $v) {
			$totalSeluruhModal += $v->kredit - $v->debit;
		}
		$labaSebelumnya = $this->labaSebelumnya($tahun);

		$total_modal = $totalSeluruhModal + $labaSebelumnya;



		//
		//Menghitung laba saat ini
		//
		

		$total_liabilitas = $total_hutang + $total_modal;
		$laba_tahun_berjalan = $total_harta - $total_liabilitas;
		

		//
		// END Menghitung laba saat ini
		//
		return [ 
			'akunAktivaLancar'      => $akunAktivaLancar,
			'total_liabilitas'           => $total_liabilitas,
			'total_harta'           => $total_harta,
			'total_modal'           => $total_modal,
			'total_hutang'           => $total_hutang,
			'akunHutang'            => $akunHutang,
			'akunModal'             => $seluruhModal,
			'laba_tahun_berjalan'   => $laba_tahun_berjalan,
			'labaSebelumnya'   => $labaSebelumnya,
			'akunAktivaTidakLancar' => $akunAktivaTidakLancar
		];
	}
	private function labaSebelumnya($tahun){
		

		$query  = "SELECT ";
		$query .= "coa_id as coa_id, ";
		$query .= "c.coa as coa, ";
		$query .= "sum(CASE WHEN debit = 1 THEN nilai ELSE 0 END) as debit, ";
		$query .= "sum(CASE WHEN debit = 0 THEN nilai ELSE 0 END) as kredit ";
		$query .= "from jurnal_umums as j join coas as c on c.id = j.coa_id ";
		$query .= "where j.created_at < '{$tahun}-01-01 00:00:00' ";
		$query .= "and j.created_at > '0000-00-00 00:00:00' ";
		$query .= "and ( coa_id like '4%' or coa_id like '5%' or coa_id like '6%' or coa_id like '7%' or coa_id like '8%' ) ";
		$query .= "group by coa_id ";
        $akuns = DB::select($query);

		$pendapatan_usahas['total_nilai'] = 0;
		$hpps['total_nilai'] = 0;
		$pendapatan_usahas['total_nilai'] = 0;
		$hpps['total_nilai'] = 0;
		$biayas['total_nilai'] = 0;
		$pendapatan_lains['total_nilai'] = 0;
		$bebans['total_nilai'] = 0;
		foreach ($akuns as $a) {
			if (substr($a->coa_id, 0, 1) === '4') {
				$pendapatan_usahas['akuns'][] = $a;
				$pendapatan_usahas['total_nilai'] += $a->kredit - $a->debit;
			} else if( substr($a->coa_id, 0, 1) === '5' ){
				$hpps['akuns'][] = $a;
				$hpps['total_nilai'] += $a->debit-$a->kredit;
			} else if( substr($a->coa_id, 0, 1) === '6' ){
				$biayas['akuns'][] = $a;
				$biayas['total_nilai'] += $a->debit-$a->kredit;
			} else if( substr($a->coa_id, 0, 1) === '7' ){
				$pendapatan_lains['akuns'][] = $a;
				$pendapatan_lains['total_nilai'] += $a->kredit - $a->debit;
			} else if( substr($a->coa_id, 0, 1) === '8' ){
				$bebans['akuns'][] = $a;
				$bebans['total_nilai'] += $a->debit - $a->kredit;
			}
		}
		return $pendapatan_usahas['total_nilai']-$hpps['total_nilai'] - $biayas['total_nilai'] + $pendapatan_lains['total_nilai'];
	}
	

}
