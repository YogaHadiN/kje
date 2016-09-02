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
		$prolanis = Pasien::find( Yoga::prolanis() );
        $hipertensi = [];
        $dm = [];
        foreach ($prolanis as $pro) {
            if ($pro->adaDm == 'bukan DM') {
                $hipertensi[] = $pro;
            }else{
                $dm[] = $pro;
            }
        }
        return view('prolanis.index', compact(
            'hipertensi',
            'dm'
        ));
	}
	
}
