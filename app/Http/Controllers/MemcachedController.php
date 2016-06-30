<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use Cache;
use App\Diagnosa;
use App\Tarif;
use App\Periksa;
use App\Classes\Yoga;

class MemcachedController extends Controller
{

	/**
	 * Display a listing of the resource.
	 * GET /memcached
	 *
	 * @return Reserikponse
	 */
	public function index()
	{
        //$periksa = Periksa::latest()->first();
        $periksa = Periksa::with('terapii.merek')->latest()->first();
        return $periksa->terapi_html;


    }


	public function data() {

		if (\Cache::has('pasien')) {
			return \Cache::get('pasien');
		} else {
			return 'Cache sudah expired';
		}

	}

}
