<?php


namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Generik;

class GeneriksController extends Controller
{

	/**
	 * Display a listing of generiks
	 *
	 * @return Response
	 */
	public function index()
	{
		$generiks = Generik::all();

		return view('generiks.index', compact('generiks'));
	}

	/**
	 * Show the form for creating a new generik
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('generiks.create');
	}

	/**
	 * Store a newly created generik in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), Generik::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Generik::create($data);

		return \Redirect::route('generiks.index');
	}

	/**
	 * Display the specified generik.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$generik = Generik::findOrFail($id);

		return view('generiks.show', compact('generik'));
	}

	/**
	 * Show the form for editing the specified generik.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$generik = Generik::find($id);

		return view('generiks.edit', compact('generik'));
	}

	/**
	 * Update the specified generik in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$generik = Generik::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Generik::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$generik->update($data);

		return \Redirect::route('generiks.index');
	}

	/**
	 * Remove the specified generik from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Generik::destroy($id);

		return \Redirect::route('generiks.index');
	}

}
