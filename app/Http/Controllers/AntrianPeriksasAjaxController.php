<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;
use App\Periksa;

class AntrianPeriksasAjaxController extends Controller
{

	public function cekada(){
		$periksa_id = Input::get('periksa_id');

		$periksa = Periksa::find($periksa_id);

		if ($periksa === null) {
			return '0';
		} else {
			return '1';
		}
	}

}