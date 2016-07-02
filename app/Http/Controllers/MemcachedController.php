<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use Cache;
use Illuminate\Support\Facades\Redis;
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
 		Cache::put('yoga', 'hsdhfklahjfdasdf', 60);
 		return Cache::get('yoga');


    }


	public function data() {

		if (\Cache::has('pasien')) {
			return \Cache::get('pasien');
		} else {
			return 'Cache sudah expired';
		}

	}

}
