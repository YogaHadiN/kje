<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Pasien;
use App\Classes\Yoga;
use DB;

class ProlanisController extends Controller
{
	public function index(){
		//return dd( Yoga::prolanis() );
		//$ht = Pasien::find( Yoga::prolanis()['hipertensi'] );
		//$dm = Pasien::find( Yoga::prolanis()['dm'] );
		$prolanis = Pasien::find( Yoga::prolanis() );
		return view('prolanis.index', compact('prolanis'));
	}
	
}
