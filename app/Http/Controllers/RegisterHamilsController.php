<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Registerhamil;

class RegisterHamilsController extends Controller
{

	/**
	 * Display a listing of registerhamils
	 *
	 * @return Response
	 */
	public function index()
	{
		$registerhamils = Registerhamil::all();

		return view('registerhamils.index', compact('registerhamils'));
	}

	/**
	 * Show the form for creating a new registerhamil
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('registerhamils.create');
	}

	/**
	 * Store a newly created registerhamil in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), Registerhamil::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Registerhamil::create($data);

		return \Redirect::route('registerhamils.index');
	}

	/**
	 * Display the specified registerhamil.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$registerhamil = Registerhamil::findOrFail($id);

		return view('registerhamils.show', compact('registerhamil'));
	}

	/**
	 * Show the form for editing the specified registerhamil.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$registerhamil = Registerhamil::find($id);

		return view('registerhamils.edit', compact('registerhamil'));
	}

	/**
	 * Update the specified registerhamil in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$registerhamil = Registerhamil::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Registerhamil::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$registerhamil->update($data);

		return \Redirect::route('registerhamils.index');
	}

	/**
	 * Remove the specified registerhamil from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Registerhamil::destroy($id);

		return \Redirect::route('registerhamils.index');
	}

}
