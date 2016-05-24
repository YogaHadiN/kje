<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Periksa;

class AsuransisExtraController extends Controller
{
	public function riwayat($id){
		$periksas = Periksa::where('asuransi_id', $id)->orderBy('created_at', 'desc')->paginate(20);
		return view('asuransis.riwayat', compact('periksas'));
	}
}
