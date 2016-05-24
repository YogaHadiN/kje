<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use DB;
use App\Rak;

class ObatsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 * GET /obats
	 *
	 * @return Response
	 */
	public function index()
	{	

		

		$days_ago = date('Y-m-d', strtotime('-10 days', strtotime(date('Y-m-d'))));
		$now = date('Y-m-d');
		$query = "SELECT sum(r.keluar) as keluar, r.rak_id as rak_id from dispensings as r where tanggal between '{$days_ago}' and '{$now}' group by rak_id";
		$dispensings = DB::select($query);
		foreach ($dispensings as $dispensing) {
			$rak_id = $dispensing->rak_id;
			$jumlah = $dispensing->keluar;
			$rak = Rak::find($rak_id);

			if($rak->stok_minimal < $jumlah){
				$rak->stok_minimal = $jumlah;
				$rak->save();
			}
		}

		$raks = Rak::orderBy('stok_minimal', 'desc')->get();


		return view('Dispensings.stokmin')->withRaks($raks);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /obats/create
	 *
	 * @return Response
	 */
	
}