<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Periksa;

class AntrianKasirsController extends Controller
{

	/**
	 * Display a listing of antriankasirs
	 *
	 * @return Response
	 */
	public function index()
	{
		$antriankasirs = Periksa::where('lewat_kasir2', '0')->where('lewat_poli', '1')->get();
		return view('antriankasirs.index', compact('antriankasirs'));
	}
}
