<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Datatables;
use App\Http\Requests;
use App\Pasien;
use Input;

class PasiensCobaController extends Controller
{
	public function index(Builder $htmlBuilder){
		if (Input::ajax()) {
			$pasiens = Pasien::with('asuransi');
			return Datatables::of($pasiens)->make(true);
		}
		$html = $htmlBuilder
			->addColumn(['data' => 'id', 'name'=>'id', 'title'=>'id'])
			->addColumn(['data' => 'nama', 'name'=>'nama', 'title'=>'nama'])
			->addColumn(['data' => 'asuransi.nama', 'name'=>'asuransi.nama', 'title'=>'Asuransi'])
			->addColumn(['data' => 'alamat', 'name'=>'alamat', 'title'=>'alamat']);
		return view('pasien_coba.index', compact('html'));
	}
	
}
