<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Input;
use DB;
use App\JurnalUmum;
use App\Classes\Yoga;

class LaporanNeracasController extends Controller
{
    public function index(){
    	return view('laporan_neracas.index');
    }

    public function show(){
    	$bulan = Input::get('bulan');
    	$tahun = Input::get('tahun');
        
		$aktivaLancar      = DB::select("SELECT coa_id as coa_id, c.coa as coa from jurnal_umums as j join coas as c on c.id = j.coa_id where j.coa_id like '11%' and j.created_at like '{$tahun}-{$bulan}%' group by coa_id");
		$aktivaLancar      = Yoga::getSumCoa($aktivaLancar, $tahun, $bulan);
		$aktivaTidakLancar = DB::select("SELECT coa_id as coa_id, c.coa as coa from jurnal_umums as j join coas as c on c.id = j.coa_id where j.coa_id like '12%' and j.created_at like '{$tahun}-{$bulan}%' group by coa_id");
		$aktivaTidakLancar = Yoga::getSumCoa($aktivaTidakLancar, $tahun, $bulan);
		$biayas            = DB::select("SELECT coa_id as coa_id, c.coa as coa from jurnal_umums as j join coas as c on c.id = j.coa_id where j.coa_id like '6%' and j.created_at like '{$tahun}-{$bulan}%' group by coa_id");
		$biayas            = Yoga::getSumCoa($biayas, $tahun, $bulan);
		$pendapatan_lains  = DB::select("SELECT coa_id as coa_id, c.coa as coa from jurnal_umums as j join coas as c on c.id = j.coa_id where j.coa_id like '7%' and j.created_at like '{$tahun}-{$bulan}%' group by coa_id");
		$pendapatan_lains  = Yoga::getSumCoa($pendapatan_lains, $tahun, $bulan);
		$bebans            = DB::select("SELECT coa_id as coa_id, c.coa as coa from jurnal_umums as j join coas as c on c.id = j.coa_id where j.coa_id like '8%' and j.created_at like '{$tahun}-{$bulan}%' group by coa_id");
		$bebans            = Yoga::getSumCoa($bebans, $tahun, $bulan);

    	return view('laporan_neracas.show', compact(
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
