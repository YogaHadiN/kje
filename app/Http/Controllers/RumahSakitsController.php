<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Rumahsakit;

class RumahSakitsController extends Controller
{

	/**
	 * Display a listing of rumahsakits
	 *
	 * @return Response
	 */
	public function index()
	{
		$rumahsakits = Rumahsakit::all();

		return view('rumahsakits.index', compact('rumahsakits'));
	}

	/**
	 * Show the form for creating a new rumahsakit
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('rumahsakits.create');
	}

	/**
	 * Store a newly created rumahsakit in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), Rumahsakit::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		Rumahsakit::create($data);

		return \Redirect::route('rumahsakits.index');
	}

	/**
	 * Display the specified rumahsakit.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$rumahsakit = Rumahsakit::findOrFail($id);

		return view('rumahsakits.show', compact('rumahsakit'));
	}

	/**
	 * Show the form for editing the specified rumahsakit.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$rumahsakit = Rumahsakit::find($id);

		return view('rumahsakits.edit', compact('rumahsakit'));
	}

	/**
	 * Update the specified rumahsakit in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rumahsakit = Rumahsakit::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Rumahsakit::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$rumahsakit->update($data);

		return \Redirect::route('rumahsakits.index');
	}

	/**
	 * Remove the specified rumahsakit from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Rumahsakit::destroy($id);

		return \Redirect::route('rumahsakits.index');
	}

}
