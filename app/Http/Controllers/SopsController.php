<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Models\Merek;
use App\Models\AturanMinum;
use App\Models\Signa;
use App\Models\Asuransi;
use App\Models\BeratBadan;
use App\Models\Icd10;
use App\Models\Sop;

class SopsController extends Controller
{

	/**
	 * Display a listing of sops
	 *
	 * @return Response
	 */
	public function index($icd10, $diagnosa_id, $asuransi_id, $berat_badan_id)
	{
   		$mereks = Merek::orderBy('id', 'desc')->get();
   		$aturanlist = AturanMinum::pluck('aturan_minum', 'id')->all();
   		$signa = Signa::pluck('signa', 'id')->all();
   		$asuransi = Asuransi::find($asuransi_id);
   		$berat_badan = BeratBadan::find($berat_badan_id);
   		$icd10 = Icd10::find($icd10);

		return view('sops.index', compact('mereks', 'aturanlist', 'signa', 'asuransi', 'berat_badan', 'icd10', 'diagnosa_id'));

	}

	/**
	 * Show the form for creating a new sop
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('sops.create');
	}

	/**
	 * Store a newly created sop in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), Sop::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$terapis = json_decode(Input::get('terapi'), true);

		foreach ($terapis as $key => $terapi) {
			
			$sop = new Sop;
			$sop->icd10_id = Input::get('icd10_id');
			$sop->berat_badan_id = Input::get('berat_badan_id');
			$sop->asuransi_id = Input::get('asuransi_id');
			$sop->terapi = json_encode($terapi);
			$sop->save();
		}


		return redirect('diagnosas/' . Input::get('diagnosa_id') . '/edit');
	}

	/**
	 * Display the specified sop.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$sop = Sop::findOrFail($id);

		return view('sops.show', compact('sop'));
	}

	/**
	 * Show the form for editing the specified sop.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$sop = Sop::find($id);

		return view('sops.edit', compact('sop'));
	}

	/**
	 * Update the specified sop in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$sop = Sop::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Sop::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$sop->update($data);

		return \Redirect::route('sops.index');
	}

	/**
	 * Remove the specified sop from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Sop::destroy($id);

		return \Redirect::route('sops.index');
	}

}
