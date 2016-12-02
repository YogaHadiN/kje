<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Classes\Yoga;
use App\JurnalUmum;

use Input;
use DB;

class LaporanLabaRugisController extends Controller
{
    public function index(){
    	return view('laporan_laba_rugis.index');
    }
    public function show(){
    	$bulan = Input::get('bulan');
    	$tahun = Input::get('tahun');
		$jurnalumums = JurnalUmum::with('coa')->where('created_at', 'like', $tahun . '-'. $bulan . '%')
											  ->whereNull('coa_id')
											  ->get();
		if ( $jurnalumums->count() > 0 ) {
			session([ 'route_coa' => 'laporan_laba_rugis' ]);
			return redirect('jurnal_umums/coa')->withPesan(Yoga::gagalFlash('Ada beberapa Chart Of Account yang harus disesuaikan dulu'));
		}

		$query  = "SELECT ";
		$query .= "coa_id as coa_id, ";
		$query .= "c.coa as coa, ";
		$query .= "abs( sum( if ( debit = 1, nilai, 0 ) ) - sum( if ( debit = 0, nilai, 0 ) ) ) as nilai ";
		$query .= "from jurnal_umums as j join coas as c on c.id = j.coa_id ";
		$query .= "where j.created_at like '{$tahun}-{$bulan}%' ";
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
				$pendapatan_usahas['total_nilai'] += $a->nilai;
			} else if( substr($a->coa_id, 0, 1) === '5' ){
				$hpps['akuns'][] = $a;
				$hpps['total_nilai'] += $a->nilai;
			} else if( substr($a->coa_id, 0, 1) === '6' ){
				$biayas['akuns'][] = $a;
				$biayas['total_nilai'] += $a->nilai;
			} else if( substr($a->coa_id, 0, 1) === '7' ){
				$pendapatan_lains['akuns'][] = $a;
				$pendapatan_lains['total_nilai'] += $a->nilai;
			} else if( substr($a->coa_id, 0, 1) === '8' ){
				$bebans['akuns'][] = $a;
				$bebans['total_nilai'] += $a->nilai;
			}
		}
		//return $pendapatan_usahas['akuns'];
    	return view('laporan_laba_rugis.show', compact(
            'pendapatan_usahas',
            'hpps',
            'biayas',
            'pendapatan_lains',
            'bulan',
            'tahun',
            'bebans'
        ));
    }
}
