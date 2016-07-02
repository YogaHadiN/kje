<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Formula;
use App\Merek;
use App\Rak;

class RaksAjaxController extends Controller
{

	
	public function ajaxrak(){

		// validasi merek

		$merek_bool = '0';
		$merek = ucwords(strtolower(Input::get('merek')));
		$endfix = Formula::find(Input::get('formula_id'))->endfix;
		$merek = $merek . ' ' . $endfix;
		// return $merek;
		if(Merek::where('merek', $merek)->get()->count() > 0 ){
			$merek_bool = '1';
		}
		// validasi rak
		$rak_bool = '0';
		$rak = Input::get('rak');

		if(Rak::where('id', $rak)->get()->count() > 0 ){
			$rak_bool = '1';
		}
		//kumpulkan dalam array
		$data = [
			'merek' => $merek_bool,
			'rak' => $rak_bool
		];
		//convert menjadi json dan kirimkan ke client
		return json_encode($data);

	}

}