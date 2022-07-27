<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Classes\Yoga;
use App\Models\AntrianPoli;
use App\Models\PengantarPasien;
use App\Models\Pasien;
use Input;

class AntrianPolisAjaxController extends Controller
{
    //
	public function getProlanis(){
		$pasien_id = Input::get('pasien_id');
		$pasien    = Pasien::find($pasien_id);
		return Yoga::golonganProlanis($pasien);
	}
}
