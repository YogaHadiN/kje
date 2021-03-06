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

    	$coa_list = [ null => '-pilih-'] + Coa::lists('coa', 'id')->all();
    	return view('buku_besars.index', compact('coa_list'));
    }
    public function show(){

        $coa_id = Input::get('coa_id');
        $bulan  = Input::get('bulan');
        $tahun  = Input::get('tahun');

		$jurnalumums = JurnalUmum::where('coa_id', $coa_id)
					->where('created_at', 'like', $tahun . '-' . $bulan . '%')
					->get();

		return view('buku_besars.show', compact(
			'jurnalumums',
			'bulan',
			'tahun',
			'coa_id'
		));
    }
}
