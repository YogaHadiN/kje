<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Kelompokcoa;

class KelompokCoasController extends Controller
{

	/**
	 * Display a listing of kelompokcoas
	 *
	 * @return Response
	 */
	public function index()
	{
		$kelompokcoas = Kelompokcoa::all();

		return view('kelompokcoas.index', compact('kelompokcoas'));
	}

	/**
	 * Show the form for creating a new kelompokcoa
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('kelompokcoas.create');
	}

	/**
	 * Store a newly created kelompokcoa in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), Kelompokcoa::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Kelompokcoa::create($data);

		return \Redirect::route('kelompokcoas.index');
	}

	/**
	 * Display the specified kelompokcoa.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$kelompokcoa = Kelompokcoa::findOrFail($id);

		return view('kelompokcoas.show', compact('kelompokcoa'));
	}

	/**
	 * Show the form for editing the specified kelompokcoa.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$kelompokcoa = Kelompokcoa::find($id);

		return view('kelompokcoas.edit', compact('kelompokcoa'));
	}

	/**
	 * Update the specified kelompokcoa in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$kelompokcoa = Kelompokcoa::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Kelompokcoa::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$kelompokcoa->update($data);

		return \Redirect::route('kelompokcoas.index');
	}

	/**
	 * Remove the specified kelompokcoa from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Kelompokcoa::destroy($id);

		return \Redirect::route('kelompokcoas.index');
	}

}
