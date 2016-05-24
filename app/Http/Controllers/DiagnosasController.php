<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use DB;
use App\Diagnosa;
use App\Merek;
use App\AturanMinum;
use App\Signa;
use App\Asuransi;
use App\BeratBadan;
use App\Sop;

class DiagnosasController extends Controller
{

	/**
	 * Display a listing of diagnosas
	 *
	 * @return Response
	 */
	public function index()
	{
		$diagnosas = Diagnosa::all();
		$icds = DB::select('select max(id) as id, max(diagnosa) as diagnosa, icd10_id from diagnosas group by icd10_id');

		return view('diagnosas.index', compact('diagnosas', 'icds'));
	}

	/**
	 * Show the form for creating a new diagnosa
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('diagnosas.create');
	}

	/**
	 * Store a newly created diagnosa in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		Diagnosa::create($data);

		return \Redirect::route('diagnosas.index');
	}

	/**
	 * Display the specified diagnosa.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$diagnosa = Diagnosa::findOrFail($id);

		return view('diagnosas.show', compact('diagnosa'));
	}

	/**
	 * Show the form for editing the specified diagnosa.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$diagnosa = Diagnosa::find($id);
   		$mereks = Merek::orderBy('id', 'desc')->get();
   		$aturanlist = AturanMinum::lists('aturan_minum', 'id')->all();
   		$signa = Signa::lists('signa', 'id')->all();
   		$asuransis = Asuransi::all();
   		$berat_badans = BeratBadan::all();
   		$sops = Sop::where('icd10_id', $diagnosa->icd10_id);

   		// return $sops->where('asuransi_id', 0)->where('berat_badan_id', 12)->count();

		return view('diagnosas.edit', compact('diagnosa','mereks','signa','aturanlist', 'asuransis', 'berat_badans', 'sops'));
	}

	/**
	 * Update the specified diagnosa in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$diagnosa = Diagnosa::findOrFail($id);


		$diagnosa->update($data);

		return \Redirect::route('diagnosas.index');
	}

	/**
	 * Remove the specified diagnosa from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Diagnosa::destroy($id);

		return \Redirect::route('diagnosas.index');
	}

}
