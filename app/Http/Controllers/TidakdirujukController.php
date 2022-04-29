<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Models\Tidakdirujuk;

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
		$tidakdirujuks = Tidakdirujuk::with('icd10.diagnosa')->get();

		return view('tidakdirujuks.index', compact('tidakdirujuks'));
	}

	

}
