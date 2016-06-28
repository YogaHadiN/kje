<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Cache;

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
		if (\Cache::has('pasien')) {
			return \Cache::get('pasien');
		} else {
            \Cache::put('pasien', 'Yogaman89', 60);
			return 'sudah diset ke ' . \Cache::get('pasien');
		}
    }


	public function data() {

		if (\Cache::has('pasien')) {
			return \Cache::get('pasien');
		} else {
			return 'Cache sudah expired';
		}

	}

}
