<?php

namespace App\Http\Controllers;

use Input;
use App\Http\Requests;
use App\Coa;

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
		return view('coas.create');
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
