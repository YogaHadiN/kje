<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use Cache;
use App\Diagnosa;
use App\Tarif;
use App\Merek;
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
		return Yoga::cacheku('yoga', Merek::all()); //Cache::get kembali mentriger query bukannya ambil dari Cache
    }


	private function data($nama, $data) {
		if (!Cache::has($nama)) {
			Cache::put($nama, $data, 60);
		}
		return Cache::get($nama); // yang ini selalu ngambil dari database lagi / cache gak jalan
	}

}
