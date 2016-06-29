<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use Cache;
use App\Diagnosa;
use App\Tarif;
use App\Classes\Yoga;

class MemcachedController extends Controller
{

	/**
	 * Display a listing of the resource.
	 * GET /memcached
	 *
	 * @return Response
	 */
	public function index()
	{

        return dd(Tarif::with('jenisTarif')->first());
        $periksa = Periksa::find($id);
    }


	public function data() {

		if (\Cache::has('pasien')) {
			return \Cache::get('pasien');
		} else {
			return 'Cache sudah expired';
		}

	}

}
