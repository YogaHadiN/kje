<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Periksa;

class KasirsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 * GET /kasirs
	 *
	 * @return Response
	 */
	public function index()
	{
		// return 'kasir koncto';

		$antriansurveys = Periksa::where('lewat_kasir', '1')->where('lewat_poli', '1')->where('lewat_kasir2', '0')->get();

		return view('surveys.index', compact('antriansurveys'));

	}



}