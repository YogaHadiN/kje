<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\JurnalUmumsController;
use App\Models\JurnalUmum;
use App\Models\Coa;
use Input;
use DB;

class NeracaSaldosController extends Controller
{
    public function index(){


    	return view('neraca_saldos.index');

    }
    public function show(){
    	$collection = collect([['product_id' => 1, 'name' => 'Desk'], ['product_id' => 2, 'name' => 'Table']]);
    	$bulan = Input::get('bulan');
    	$tahun = Input::get('tahun');

		$jurn = new JurnalUmumsController;
		$jurn->notReadh($bulan, $tahun, 'neraca_saldos');

        $query = "SELECT coa_id as coa_id, ";
        $query .= "c.coa as coa ";
        $query .= "from jurnal_umums as j ";
        $query .= "join coas as c on c.id = j.coa_id ";
        $query .= "where j.created_at like '{$tahun}-{$bulan}%' ";
		$query .= "AND j.tenant_id = " . session()->get('tenant_id') . " ";
        $query .= "group by coa_id";
    	$jurnalumums = DB::select($query);

    	$jurnalumums = json_encode($jurnalumums);
    	$jurnalumums = json_decode($jurnalumums, true);

    	foreach ($jurnalumums as $k => $v) {

    		$jurnals = JurnalUmum::where('coa_id', $v['coa_id'])
    				->where('created_at', 'like', $tahun . '-' . $bulan . '%')->get();

    		$value = 0;
    		foreach ($jurnals as $key => $j) {
	    		if ($j->debit == '1') {
	    			$value += $j->nilai;
	    		} else {
	    			$value -= $j->nilai;
	    		}
    		}

    		$jurnalumums[$k]['nilai'] = $value;
    	}

    	return view('neraca_saldos.show', compact('jurnalumums'));

    }
}
