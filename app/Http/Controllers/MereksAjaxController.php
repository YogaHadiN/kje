<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Merek;

class MereksAjaxController extends Controller

{
	
	public function ajaxmerek(){

		// validasi merek

		$merek_bool = '0';

		$merek = ucwords(strtolower(Input::get('merek')));
		$endfix = Input::get('endfix');
		$merek = $merek . ' ' . $endfix;
		// return $merek;
		if(Merek::where('merek', $merek)->get()->count() > 0 ){
			$merek_bool = '1';
		}
		//convert menjadi json dan kirimkan ke client
		return $merek_bool;

	}

}