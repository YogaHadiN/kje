<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Staf;
use App\BayarGaji;

class StafsCustomController extends Controller
{

	public function __construct()
	 {
		 $this->middleware('super', ['only' => ['pengantar',
			 'gaji'
		 ]]);
	 }
    public function gaji($id){
    	$stafArray = BayarGaji::where('staf_id', $id)->latest()->paginate(20);
		//return dd( $stafArray );
    	$staf = Staf::find($id);
		return view('stafs.gaji', compact(
			'staf',
			'stafArray'
		));
    }
    
}
