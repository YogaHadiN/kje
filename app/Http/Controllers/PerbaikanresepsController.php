<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Models\Perbaikanresep;
use App\Models\Classes\Yoga;


class PerbaikanresepsController extends Controller
{
	public function show()
	{
		$mulai = Yoga::datePrep(Input::get('mulai'));
		$akhir = Yoga::datePrep(Input::get('akhir'));

		$perbaikans = Perbaikanresep::whereRaw("date(created_at) between '{$mulai} 00:00:00' and '{$akhir} 23:59:59'")->orderBy('id', 'desc')->paginate(20);

		return view('perbaikanreseps.show', compact('perbaikans', 'mulai', 'akhir'));
	}
}
