<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\LaporanLabaRugisController;
use Input;
use DB;
use Carbon\Carbon;
use App\Models\JurnalUmum;
use App\Models\Coa;
use App\Models\Classes\Yoga;

class LaporanNeracasController extends Controller
{

	public function __construct()
	 {
		 $this->middleware('super', ['only' => [
			 'edit',
			 'update'
		 ]]);
		 $this->middleware('notready', ['only' => [
			 'show',
			 'normalisasi'
		 ]]);
		 $this->middleware('normalisasi', ['only' => [
			 'normalisasi'
		 ]]);
	 }

    public function index(){
		$bikinan = false;
		return view('laporan_neracas.index', compact('bikinan'));
	}

    public function indexBikinan(){
		$bikinan = true;
		return view('laporan_neracas.index', compact('bikinan'));
	}

    public function showBikinan(){
		$tanggal = Input::get('tanggal');
		$path    = Input::path();
		$temp    = $this->temp($tanggal, true);
		$akunAktivaLancar      = $temp['akunAktivaLancar'];
		$total_harta           = $temp['total_harta'];
		$akunHutang            = $temp['akunHutang'];
		$akunModal             = $temp['akunModal'];
		$total_liabilitas      = $temp['total_liabilitas'];
		$laba_tahun_berjalan   = $temp['laba_tahun_berjalan'];
		$akunAktivaTidakLancar = $temp['akunAktivaTidakLancar'];
		$labaSebelumnya        = $temp['labaSebelumnya'];
		$total_modal           = $temp['total_modal'];
		$total_hutang          = $temp['total_hutang'];

    	return view('laporan_neracas.show', compact(
            'akunAktivaLancar',
            'tanggal',
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
    public function show(){
		$tanggal = Input::get('tanggal');
		$path    = Input::path();
		$temp    = $this->temp($tanggal);
		$akunAktivaLancar      = $temp['akunAktivaLancar'];
		$total_harta           = $temp['total_harta'];
		$akunHutang            = $temp['akunHutang'];
		$akunModal             = $temp['akunModal'];
		$total_liabilitas      = $temp['total_liabilitas'];
		$laba_tahun_berjalan   = $temp['laba_tahun_berjalan'];
		$akunAktivaTidakLancar = $temp['akunAktivaTidakLancar'];
		$labaSebelumnya        = $temp['labaSebelumnya'];
		$total_modal           = $temp['total_modal'];
		$total_hutang          = $temp['total_hutang'];

    	return view('laporan_neracas.show', compact(
            'akunAktivaLancar',
            'tanggal',
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
	public function temp($tanggal, $bikinan = false){
		$tanggal       = Carbon::createFromFormat('d-m-Y',$tanggal);
		$tanggal_awal  = '2017-12-01 00:00:00';
		$tanggal_akhir = $tanggal->format('Y-m-d 23:59:59');

		/* dd( $tanggal_awal, $tanggal_akhir ); */

		$query = "SELECT co.id as coa_id, ";
		$query .= "co.coa, ";
		if ( $bikinan ) {
			$query .= "px.asuransi_id as asuransi_id, ";
		}
		$query .= "CASE WHEN debit = 1 THEN nilai ELSE 0 END as debit, ";
		$query .= "CASE WHEN debit = 0 THEN nilai ELSE 0 END as kredit, ";
		$query .= "ju.jurnalable_type as jurnalable_type, ";
		$query .= "co.kelompok_coa_id ";
		$query .= "FROM jurnal_umums as ju ";
		$query .= "join coas as co on co.id = ju.coa_id ";
		if ($bikinan) {
			$query .= "left join periksas as px on px.id = ju.jurnalable_id ";
		}
		$query .= "where ";
		$query .= " ( ";
		$query .= "co.kelompok_coa_id = 11 ";
		$query .= "or co.kelompok_coa_id = 12 ";
		$query .= "or co.kelompok_coa_id = 2 ";
		$query .= "or co.kelompok_coa_id = 3 ";
		$query .= ") ";
		$query .= "and ju.created_at <= '{$tanggal_akhir}' ";
		$query .= "and ju.created_at >= '{$tanggal_awal}' ";
		$query .= "and ju.tenant_id = " . session()->get('tenant_id') . " ";
		/* $query .= " group by co.id"; */

		/* dd( $query ); */

		$dataAll = DB::select($query);

		 $akunAktivaLancar      = [];
		 $akunAktivaTidakLancar = [];
		 $akunHutang            = [];
		 $seluruhModal          = [];

		 $data = [];
		 foreach ($dataAll as $d) {
			 /* dd($d->kelompok_coa_id); */

			if ( 
				$bikinan 
				&& $d->jurnalable_type == 'App\Models\Periksa' 
				&& $d->asuransi_id == '0'
			) {
				unset($akun);
				continue;
			}

			$data[ $d->coa_id ]['coa_id']          = $d->coa_id;
			$data[ $d->coa_id ]['coa']             = $d->coa;
			$data[ $d->coa_id ]['kelompok_coa_id'] = $d->kelompok_coa_id;
			if ( !isset( $data[ $d->coa_id ]['debit'] ) ) {
				$data[ $d->coa_id ]['debit'] = 0;
			}

			if ( !isset( $data[ $d->coa_id ]['kredit'] ) ) {
				$data[ $d->coa_id ]['kredit'] = 0;
			}
			$data[ $d->coa_id ]['debit'] += $d->debit;
			$data[ $d->coa_id ]['kredit'] += $d->kredit;
		 }

		 foreach ($data as $d) {
			if ($d['kelompok_coa_id'] == 11){
		 		$akunAktivaLancar[] = $d;
			} else if ($d['kelompok_coa_id'] == 12){
		 		$akunAktivaTidakLancar[] = $d;
			} else if ($d['kelompok_coa_id'] == 2){
		 		$akunHutang[] = $d;
			} else if ($d['kelompok_coa_id'] == 3){
		 		$seluruhModal[] = $d;
			}
		 }

		 /* dd( $akunAktivaTidakLancar ); */

		$total_harta = 0;

		foreach ($akunAktivaLancar as $v) {
			$total_harta += $v['debit'] - $v['kredit'];
		}

		foreach ($akunAktivaTidakLancar as $v) {
			$total_harta += $v['debit'] -$v['kredit'];
		}

		$total_hutang = 0;
		foreach ($akunHutang as $v) {
			$total_hutang += $v['kredit'] - $v['debit'];
		}

		//total modal = seluruh modal + laba tahun sebelumnya

		$totalSeluruhModal = 0;
		foreach ($seluruhModal as $v) {
			$totalSeluruhModal += $v['kredit'] - $v['debit'];
		}

		if ( $bikinan ) {
			$labaSebelumnya = $this->hitungLaba( $tanggal_awal, $tanggal->copy()->subYear()->format('Y-12-31 23:59:59'), true);
		} else {
			$labaSebelumnya = $this->hitungLaba( $tanggal_awal, $tanggal->copy()->subYear()->format('Y-12-31 23:59:59'));
		}
		$total_modal = $totalSeluruhModal + $labaSebelumnya;

		//
		//Menghitung laba saat ini
		//
		
		$llr = new LaporanLabaRugisController;

		$total_liabilitas    = $total_hutang + $total_modal;
		$tanggal_awal = max([$tanggal->format('Y-01-01 00:00:00'), $tanggal_awal]);
		if ( $bikinan ) {
			$laba_tahun_berjalan = $this->hitungLaba($tanggal_awal , $tanggal_akhir, true);
		} else {
			$laba_tahun_berjalan = $this->hitungLaba($tanggal_awal , $tanggal_akhir);
		}

		/* dd($tanggal_awal); */

		/* dd($laba_tahun_berjalan); */

		
		/* dd($tanggal_awal, $tanggal_akhir, $laba_tahun_berjalan); */

		//
		// END Menghitung laba saat ini
		//
		return [ 
			'akunAktivaLancar'      => $akunAktivaLancar,
			'total_liabilitas'      => $total_liabilitas,
			'total_harta'           => $total_harta,
			'total_modal'           => $total_modal,
			'total_hutang'          => $total_hutang,
			'akunHutang'            => $akunHutang,
			'akunModal'             => $seluruhModal,
			'laba_tahun_berjalan'   => $laba_tahun_berjalan,
			'labaSebelumnya'        => $labaSebelumnya,
			'akunAktivaTidakLancar' => $akunAktivaTidakLancar
		];
	}
	private function labaSebelumnya($tahun, $bikinan = false){
		

		$query  = "SELECT ";
		if ( $bikinan ) {
			$query .= "px.asuransi_id as asuransi_id, ";
		}
		$query .= "coa_id as coa_id, ";
		$query .= "j.jurnalable_type as jurnalable_type, ";
		$query .= "c.coa as coa, ";
		$query .= "sum(CASE WHEN debit = 1 THEN nilai ELSE 0 END) as debit, ";
		$query .= "sum(CASE WHEN debit = 0 THEN nilai ELSE 0 END) as kredit ";
		$query .= "from jurnal_umums as j join coas as c on c.id = j.coa_id ";
		$query .= "left join periksas as px on px.id = j.jurnalable_id ";
		$query .= "where j.created_at < '{$tahun}-01-01 00:00:00' ";
		$query .= "and j.created_at > '2017-11-30 00:00:00' ";
		$query .= "and j.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and ( coa_id like '4%' or coa_id like '5%' or coa_id like '6%' or coa_id like '7%' or coa_id like '8%' ) ";

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
	private function hitungLaba( $tanggal_awal, $tanggal_akhir, $bikinan = false ){
		$llr = new LaporanLabaRugisController;
		if ( $bikinan ) {
			$query = $llr->tempLaporanLabaRugiRangeByDate( $tanggal_awal, $tanggal_akhir, true);
		} else {
			$query = $llr->tempLaporanLabaRugiRangeByDate( $tanggal_awal, $tanggal_akhir);
		}
		return $query['pendapatan_usahas']['total_nilai'] - $query['hpps']['total_nilai'] - $query['biayas']['total_nilai'] + $query['pendapatan_lains']['total_nilai'] - $query['bebans']['total_nilai'];
	}
}
