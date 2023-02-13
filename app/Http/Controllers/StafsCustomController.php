<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Staf;
use App\Models\BayarGaji;

class StafsCustomController extends Controller
{

	public function __construct()
	 {
		 $this->middleware('super', ['only' => ['pengantar',
			 'gaji'
		 ]]);
	 }
    public function gaji($id){
    	$gajis = BayarGaji::where('staf_id', $id)->latest()->paginate(20);
    	$staf = Staf::find($id);
		return view('stafs.gaji', compact(
			'gajis',
			'staf'
		));
    }
    
}
