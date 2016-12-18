<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Antrian;

class AntriansController extends Controller
{
	public function create(){
		return view('antrians.create', compact(''));
	}
	public function store(){
		$a       = Antrian::find(1);
		$a->antrian_terakhir   = (int) $a->antrian_terakhir + 1;
		$a->save();

		return $a->antrian_terakhir;
	}
	
	
}
