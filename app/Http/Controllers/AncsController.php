<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Periksa;

class AncsController extends Controller
{
	public function show($id)
		{
			$periksa = Periksa::findOrFail($id);

			return view('ancs.show', compact('periksa'));
		}
}
