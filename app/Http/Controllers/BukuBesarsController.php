<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use App\Http\Requests;
use App\JurnalUmum;
use App\Coa;

class BukuBesarsController extends Controller
{
    public function index(){

    	$jurnalumums = JurnalUmum::where('created_at','like',date('Y-m') . '%')->get();
    	$coa_ids = [];

    	foreach ($jurnalumums as $k => $v) {
    		$coa_ids[] = $v->coa_id;
    	}


    	$coa_ids = array_keys(array_flip($coa_ids)); 

    	$coa_list = [ null => '-pilih-'] + Coa::whereIn('id', $coa_ids)->lists('coa', 'id')->all();
    	return view('buku_besars.index', compact('coa_list'));
    }
    public function show(){

        // return Input::all();
        $coa_id = Input::get('coa_id');
        $bulan  = Input::get('bulan');
        $tahun  = Input::get('tahun');

        $jurnalumums = JurnalUmum::where('coa_id', $coa_id)->where('created_at', 'like', $tahun . '-' . $bulan . '%')->get();
        // return $jurnalumums;

    	return view('buku_besars.show', compact('jurnalumums'));
    }
}
