<?php


namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Classes\Yoga;
use DB;
use App\Rak;

class DispensingsController extends Controller
{


	public function index()
	{	
		$mulai = Yoga::datePrep(Input::get('mulai'));
		$akhir = Yoga::datePrep(Input::get('akhir'));
		$rak_id = Input::get('rak_id');

		// return 'mulai = ' . $mulai . ' akhir = ' . $akhir . ' rak_id = ' . $rak_id . ' ';
		$dispensings = DB::select("SELECT id, tanggal, rak_id, sum(keluar) as keluar, sum(masuk) as masuk, dispensable_id FROM dispensings where tanggal <= '{$akhir}' AND tanggal >= '{$mulai}' AND rak_id like '{$rak_id}' group by rak_id");
		// $dispensings = Dispensing::where('tanggal', '>=', $mulai)->where('tanggal', '<=', $akhir)->where('rak_id', 'like', $rak_id)->groupBy('rak_id')->get();
		$raks = Rak::all();

		return view('dispensings.index', compact('dispensings', 'raks'));
	}

	

}
