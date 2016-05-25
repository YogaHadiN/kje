<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PerbaikanresepsController extends Controller
{
	public function show()
	{
		$mulai = Yoga::datePrep(Input::get('mulai'));
		$akhir = Yoga::datePrep(Input::get('akhir'));

		$perbaikans = Perbaikanreseps::whereRaw("created_at between '{$mulai} 00:00:00' and '{$akhir} 23:59:59'")->orderBy('id', 'desc')->paginate(20);

		return view('perbaikantrxs.show', compact('perbaikans', 'mulai', 'akhir'));
	}
}
