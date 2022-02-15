<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use App\Http\Requests;
use App\Models\JurnalUmum;
use App\Models\Coa;

class BukuBesarsController extends Controller
{
    public function index(){

    	$coa_list = [ null => '-pilih-'] + Coa::pluck('coa', 'id')->all();
    	return view('buku_besars.index', compact('coa_list'));
    }
    public function show(){

        $coa_id = Input::get('coa_id');
        $bulan  = Input::get('bulan');
        $tahun  = Input::get('tahun');

		$jurnalumums = JurnalUmum::where('coa_id', $coa_id)
					->where('created_at', 'like', $tahun . '-' . $bulan . '%')
					->toSql();
		dd( $jurnalumums );

		$coa = Coa::find($coa_id);

		return view('buku_besars.show', compact(
			'jurnalumums',
			'bulan',
			'coa',
			'tahun',
			'coa_id'
		));
    }
}
