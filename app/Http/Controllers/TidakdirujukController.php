<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Tidakdirujuk;

class TidakdirujukController extends Controller
{

	/**
	 * Display a listing of the resource.
	 * GET /tidakdirujuk
	 *
	 * @return Response
	 */
	public function index()
	{
		$tidakdirujuks = Tidakdirujuk::all();
		return view('tidakdirujuks.index', compact('tidakdirujuks'));
	}

	

}