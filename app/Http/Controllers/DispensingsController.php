<?php


namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Classes\Yoga;
use DB;
use App\Rak;
use App\Dispensing;

class DispensingsController extends Controller
{


	public function index()
	{	
		//return dd( Input::all() );
		$mulai = Yoga::datePrep(Input::get('mulai'));
		$akhir = Yoga::datePrep(Input::get('akhir'));
		$rak_id = Input::get('rak_id');

		// return 'mulai = ' . $mulai . ' akhir = ' . $akhir . ' rak_id = ' . $rak_id . ' ';
		//$dispensings = DB::select("SELECT id, tanggal, rak_id, sum(keluar) as keluar, sum(masuk) as masuk, dispensable_id FROM dispensings where tanggal <= '{$akhir}' AND tanggal >= '{$mulai}' AND rak_id like '{$rak_id}' group by tanggal");
		$dispensings = DB::select("SELECT id, tanggal, rak_id, sum(keluar) as keluar, sum(masuk) as masuk, dispensable_id, dispensable_type FROM dispensings where tanggal <= '{$akhir}' AND tanggal >= '{$mulai}' AND rak_id like '{$rak_id}' group by tanggal");
		// $dispensings = Dispensing::where('tanggal', '>=', $mulai)->where('tanggal', '<=', $akhir)->where('rak_id', 'like', $rak_id)->groupBy('rak_id')->get();
		$rak = Rak::find($rak_id);
		$raks = Rak::all();

		return view('Dispensings.index', compact(
			'dispensings', 
			'rak',  
			'mulai',  
			'akhir',  
			'raks'
		));
	}
	public function perTanggal($rak_id, $tanggal){
		$dispensings = Dispensing::with('dispensable')
									->where('tanggal', $tanggal)
									->where('rak_id', $rak_id)
									->get();
		$rak = Rak::find($rak_id);
		return view('Dispensings.pertanggal', compact(
			'dispensings',
			'rak',
			'tanggal'
		));
	}
	

	

}
