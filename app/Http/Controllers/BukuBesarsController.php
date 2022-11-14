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
        $tanggal_awal  = Input::get('tanggal_awal');
        $tanggal_akhir  = Input::get('tanggal_akhir');

        $jurnalumums = JurnalUmum::with('jurnalable.staf')
                    ->where('coa_id', $coa_id)
					->whereRaw("created_at between '" . $tanggal_awal . "' and '" . $tanggal_akhir . "'")
					->get();

		$coa = Coa::find($coa_id);

		return view('buku_besars.show', compact(
			'jurnalumums',
			'tanggal_awal',
			'coa',
			'tanggal_akhir',
			'coa_id'
		));
    }
}
