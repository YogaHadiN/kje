<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Tidakdirujuk;

class TidakdirujuksController extends Controller
{

	/**
	 * Display a listing of tidakdirujuks
	 *
	 * @return Response
	 */
	public function index()
	{
		$tidakdirujuks = Tidakdirujuk::all();

		return view('tidakdirujuks.index', compact('tidakdirujuks'));
	}

	/**
	 * Show the form for creating a new tidakdirujuk
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('tidakdirujuks.create');
	}

	/**
	 * Store a newly created tidakdirujuk in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), Tidakdirujuk::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Tidakdirujuk::create($data);

		return \Redirect::route('tidakdirujuks.index');
	}

	/**
	 * Display the specified tidakdirujuk.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$tidakdirujuk = Tidakdirujuk::findOrFail($id);

		return view('tidakdirujuks.show', compact('tidakdirujuk'));
	}

	/**
	 * Show the form for editing the specified tidakdirujuk.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tidakdirujuk = Tidakdirujuk::find($id);

		return view('tidakdirujuks.edit', compact('tidakdirujuk'));
	}

	/**
	 * Update the specified tidakdirujuk in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$tidakdirujuk = Tidakdirujuk::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Tidakdirujuk::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$tidakdirujuk->update($data);

		return \Redirect::route('tidakdirujuks.index');
	}

	/**
	 * Remove the specified tidakdirujuk from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Tidakdirujuk::destroy($id);

		return \Redirect::route('tidakdirujuks.index');
	}

}
