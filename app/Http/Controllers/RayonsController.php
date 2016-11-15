<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Rayon;
use App\Classes\Yoga;
use Input;

class RayonsController extends Controller
{
	public function create(){
		$rayons = Rayon::all();
		return view('rayons.create', compact('rayons'));
	}
	public function store(){

		$rules = [
		  "rayon" => "required"
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$r       = new Rayon;
		$r->rayon   = Input::get('rayon');
		$confirm = $r->save();

		if ($confirm) {
			$pesan = Yoga::suksesFlash('Rayon baru ' . $r->id . ' - ' . $r->rayon . ' telah <strong>BERHASIL</strong>');
		} else {
			$pesan = Yoga::gagalFlash('Rayon baru ' . $r->id . ' - ' . $r->rayon . ' telah <strong>GAGAL</strong>');
		}

		return redirect('rumahsakits/create')->withPesan($pesan);
	}
	
	
}
