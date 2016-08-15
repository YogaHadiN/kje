<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Tipelaporankasir;

class TipeLaporanKasirsController extends Controller
{

	/**
	 * Display a listing of tipelaporankasirs
	 *
	 * @return Response
	 */
	public function index()
	{
		$tipelaporankasirs = Tipelaporankasir::all();

		return view('tipelaporankasirs.index', compact('tipelaporankasirs'));
	}

	/**
	 * Show the form for creating a new tipelaporankasir
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('tipelaporankasirs.create');
	}

	/**
	 * Store a newly created tipelaporankasir in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), Tipelaporankasir::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Tipelaporankasir::create($data);

		return \Redirect::route('tipelaporankasirs.index');
	}

	/**
	 * Display the specified tipelaporankasir.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$tipelaporankasir = Tipelaporankasir::findOrFail($id);

		return view('tipelaporankasirs.show', compact('tipelaporankasir'));
	}

	/**
	 * Show the form for editing the specified tipelaporankasir.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tipelaporankasir = Tipelaporankasir::find($id);

		return view('tipelaporankasirs.edit', compact('tipelaporankasir'));
	}

	/**
	 * Update the specified tipelaporankasir in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$tipelaporankasir = Tipelaporankasir::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Tipelaporankasir::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$tipelaporankasir->update($data);

		return \Redirect::route('tipelaporankasirs.index');
	}

	/**
	 * Remove the specified tipelaporankasir from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Tipelaporankasir::destroy($id);

		return \Redirect::route('tipelaporankasirs.index');
	}

}
