<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Classes\Yoga;
use App\AntrianPoli;
use App\PengantarPasien;
use App\Pasien;
use Input;

class AntrianPolisAjaxController extends Controller
{
    //
	public function getProlanis(){
		$pasien_id = Input::get('pasien_id');
		return Yoga::golonganProlanis($pasien_id);
	}
}
