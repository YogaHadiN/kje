<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Presentasi;

class PresentasisController extends Controller
{

	/**
	 * Display a listing of presentasis
	 *
	 * @return Response
	 */
	public function index()
	{
		$presentasis = Presentasi::all();

		return view('presentasis.index', compact('presentasis'));
	}

	/**
	 * Show the form for creating a new presentasi
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('presentasis.create');
	}

	/**
	 * Store a newly created presentasi in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), Presentasi::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Presentasi::create($data);

		return \Redirect::route('presentasis.index');
	}

	/**
	 * Display the specified presentasi.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$presentasi = Presentasi::findOrFail($id);

		return view('presentasis.show', compact('presentasi'));
	}

	/**
	 * Show the form for editing the specified presentasi.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$presentasi = Presentasi::find($id);

		return view('presentasis.edit', compact('presentasi'));
	}

	/**
	 * Update the specified presentasi in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$presentasi = Presentasi::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Presentasi::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$presentasi->update($data);

		return \Redirect::route('presentasis.index');
	}

	/**
	 * Remove the specified presentasi from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Presentasi::destroy($id);

		return \Redirect::route('presentasis.index');
	}

}
