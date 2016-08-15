<?php


namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Signa;

class SignasController extends Controller
{

	/**
	 * Display a listing of signas
	 *
	 * @return Response
	 */
	public function index()
	{
		$signas = Signa::all();

		return view('signas.index', compact('signas'));
	}

	/**
	 * Show the form for creating a new signa
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('signas.create');
	}

	/**
	 * Store a newly created signa in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), Signa::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Signa::create($data);

		return \Redirect::route('signas.index');
	}

	/**
	 * Display the specified signa.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$signa = Signa::findOrFail($id);

		return view('signas.show', compact('signa'));
	}

	/**
	 * Show the form for editing the specified signa.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$signa = Signa::find($id);

		return view('signas.edit', compact('signa'));
	}

	/**
	 * Update the specified signa in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$signa = Signa::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Signa::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$signa->update($data);

		return \Redirect::route('signas.index');
	}

	/**
	 * Remove the specified signa from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Signa::destroy($id);

		return \Redirect::route('signas.index');
	}

}
