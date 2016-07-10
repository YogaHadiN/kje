<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;
use Illuminate\Contracts\Filesystem\Filesystem;
use Cache;
use Storage;
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
		Storage::disk('local')->put('file.txt', 'Contents');
    }



	public function data() {

		if (\Cache::has('pasien')) {
			return \Cache::get('pasien');
		} else {
			return 'Cache sudah expired';
		}

	}

}
