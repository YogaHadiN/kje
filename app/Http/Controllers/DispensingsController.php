<?php


namespace App\Http\Controllers;

use Input;

use App\Http\Requests;
use DB;

use App\Models\Classes\Yoga;
use App\Models\Rak;
use App\Models\Dispensing;

class DispensingsController extends Controller
{


	public function index()
	{	
		$mulai    = Yoga::datePrep(Input::get('mulai'));
		$akhir    = Yoga::datePrep(Input::get('akhir'));
		$merek_id = Input::get('merek_id');

		$quer = "SELECT id, ";
		$quer .= "tanggal, ";
		$quer .= "merek_id, ";
		$quer .= "sum(keluar) as keluar, ";
		$quer .= "sum(masuk) as masuk, ";
		$quer .= "dispensable_id, ";
		$quer .= "dispensable_type ";
		$quer .= "FROM dispensings ";
		$quer .= "where tanggal <= '{$akhir}' ";
		$quer .= "AND tanggal >= '{$mulai}' ";
		$quer .= "AND merek_id like '{$merek_id}' ";
		$quer .= "AND tenant_id = " . session()->get('tenant_id') . " ";
		$quer .= "group by tanggal";

		$dispensings = DB::select($quer);
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
