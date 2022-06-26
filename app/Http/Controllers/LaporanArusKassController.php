<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Input;
use DB;
use App\Models\Classes\Yoga;

class LaporanArusKassController extends Controller
{
     public function index(){
    	return view('laporan_laba_rugis.index');
    }
    public function show(){
    	$bulan = Input::get('bulan');
    	$tahun = Input::get('tahun');
        
        $query              = "SELECT coa_id as coa_id, ";
        $query             .= "c.coa as coa ";
        $query             .= "from jurnal_umums as j ";
        $query             .= "join coas as c on c.id = j.coa_id ";
        $query             .= "where j.coa_id like '4%' ";
        $query             .= "and j.created_at like '{$tahun}-{$bulan}%' ";
		$query             .= "AND j.tenant_id = " . session()->get('tenant_id') . " ";
        $query             .= "group by coa_id";
        $pendapatan_usahas  = DB::select($query);
        $pendapatan_usahas  = Yoga::getSumCoa($pendapatan_usahas, $tahun, $bulan);

        $query  = "SELECT coa_id as coa_id, ";
        $query .= "c.coa as coa ";
        $query .= "from jurnal_umums as j ";
        $query .= "join coas as c on c.id = j.coa_id ";
        $query .= "where j.coa_id like '5%' ";
		$query .= "AND j.tenant_id = " . session()->get('tenant_id') . " ";
        $query .= "and j.created_at like '{$tahun}-{$bulan}%' ";
        $query .= "group by coa_id";
        $hpps   = DB::select($query);
        $hpps   = Yoga::getSumCoa($hpps, $tahun, $bulan);

        $query   = "SELECT ";
        $query  .= "coa_id as coa_id, ";
        $query  .= "c.coa as coa ";
        $query  .= "from jurnal_umums as j ";
        $query  .= "join coas as c on c.id = j.coa_id ";
        $query  .= "where j.coa_id like '6%' ";
		$query  .= "AND j.tenant_id = " . session()->get('tenant_id') . " ";
        $query  .= "and j.created_at like '{$tahun}-{$bulan}%' ";
        $query  .= "group by coa_id";
        $biayas  = DB::select($query);
        $biayas  = Yoga::getSumCoa($biayas, $tahun, $bulan);

        $query             = "SELECT ";
        $query            .= "coa_id as coa_id, ";
        $query            .= "c.coa as coa ";
        $query            .= "from jurnal_umums as j ";
        $query            .= "join coas as c on c.id = j.coa_id ";
        $query            .= "where j.coa_id like '7%' ";
		$query            .= "AND j.tenant_id = " . session()->get('tenant_id') . " ";
        $query            .= "and j.created_at like '{$tahun}-{$bulan}%' ";
        $query            .= "group by coa_id";
        $pendapatan_lains  = DB::select($query);
        $pendapatan_lains  = Yoga::getSumCoa($pendapatan_lains, $tahun, $bulan);


        $query   = "SELECT coa_id as coa_id, ";
        $query  .= "c.coa as coa ";
        $query  .= "from jurnal_umums as j ";
        $query  .= "join coas as c on c.id = j.coa_id ";
        $query  .= "where j.coa_id like '8%' ";
		$query  .= "AND j.tenant_id = " . session()->get('tenant_id') . " ";
        $query  .= "and j.created_at like '{$tahun}-{$bulan}%' ";
        $query  .= "group by coa_id";
        $bebans  = DB::select($query);
        $bebans  = Yoga::getSumCoa($bebans, $tahun, $bulan);

        // return $pendapatan_usahas;

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
