<?php

namespace App\Http\Controllers;

use Input;
use App\Http\Requests;
use App\Coa;
use App\KelompokCoa;

class CoasController extends Controller
{

	/**
	 * Display a listing of coas
	 *
	 * @return Response
	 */
	public function index()
	{
		$coas = Coa::with('kelompokCoa')->latest()->paginate(10);
		return view('coas.index', compact('coas'));
	}

	/**
	 * Show the form for creating a new coa
	 *
	 * @return Response
	 */
	public function create()
	{
		$kelompokCoaList = [null => 'pilih'];
		$kelompok_coa_list = KelompokCoa::all();
		foreach ($kelompok_coa_list as $kel_coa) {
			$kelompokCoaList[] = [ $kel_coa->id => $kel_coa->id . ' - ' . $kel_coa->kelompok_coa ];
		}
		return $kelompokCoaList;
		return view('coas.create', compact('kelompokCoaList'));
	}

	/**
	 * Store a newly created coa in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		Coa::create($data);

		return \Redirect::route('coas.index');
	}

	/**
	 * Display the specified coa.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$coa = Coa::findOrFail($id);

		return view('coas.show', compact('coa'));
	}

	/**
	 * Show the form for editing the specified coa.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$coa = Coa::find($id);

		return view('coas.edit', compact('coa'));
	}

	/**
	 * Update the specified coa in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$coa = Coa::findOrFail($id);


		$coa->update($data);

		return \Redirect::route('coas.index');
	}

	/**
	 * Remove the specified coa from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Coa::destroy($id);

		return \Redirect::route('coas.index');
	}

}
