<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Registeranc;

class RegisterAncsController extends Controller
{

	/**
	 * Display a listing of registerancs
	 *
	 * @return Response
	 */
	public function index()
	{
		$registerancs = Registeranc::all();

		return view('registerancs.index', compact('registerancs'));
	}

	/**
	 * Show the form for creating a new registeranc
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('registerancs.create');
	}

	/**
	 * Store a newly created registeranc in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), Registeranc::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Registeranc::create($data);

		return \Redirect::route('registerancs.index');
	}

	/**
	 * Display the specified registeranc.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$registeranc = Registeranc::findOrFail($id);

		return view('registerancs.show', compact('registeranc'));
	}

	/**
	 * Show the form for editing the specified registeranc.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$registeranc = Registeranc::find($id);

		return view('registerancs.edit', compact('registeranc'));
	}

	/**
	 * Update the specified registeranc in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$registeranc = Registeranc::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Registeranc::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$registeranc->update($data);

		return \Redirect::route('registerancs.index');
	}

	/**
	 * Remove the specified registeranc from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Registeranc::destroy($id);

		return \Redirect::route('registerancs.index');
	}

}
