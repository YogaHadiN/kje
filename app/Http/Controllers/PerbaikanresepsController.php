<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Perbaikanresep;
use App\Classes\Yoga;


class PerbaikanresepsController extends Controller
{
	public function show()
	{
		$mulai = Yoga::datePrep(Input::get('mulai'));
		$akhir = Yoga::datePrep(Input::get('akhir'));

		$perbaikans = Perbaikanresep::whereRaw("created_at between '{$mulai} 00:00:00' and '{$akhir} 23:59:59'")->orderBy('id', 'desc')->paginate(20);

		return view('perbaikanreseps.show', compact('perbaikans', 'mulai', 'akhir'));
	}
}
