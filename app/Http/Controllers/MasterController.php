<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Classes\Yoga;
use App\Models\Antrian;

class MasterController extends Controller
{
    //
	public function antrianTerakhir(){
		$antrian_sudah = Yoga::antrianTerakhir( date('Y-m-d') );
		$antrian_belum = Antrian::find(1)->antrian_terakhir;
		if ( $antrian_belum > $antrian_sudah ) {
			return $antrian_belum;
		}
		return 0;
	}
	
}
