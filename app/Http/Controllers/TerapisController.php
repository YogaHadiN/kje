<?php


namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Terapi;

class TerapisController extends Controller
{

	/**
	 * Display a listing of terapis
	 *
	 * @return Response
	 */
	public function index($periksa_id)
	{
		$terapis = Terapi::where('periksa_id', $periksa_id)->get();

		return view('terapis.index', compact('terapis', 'periksa_id'));
	}

	/**
	 * Show the form for creating a new terapi
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('terapis.create');
	}

	/**
	 * Store a newly created terapi in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), Terapi::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Terapi::create($data);

		return \Redirect::route('terapis.index');
	}

	/**
	 * Display the specified terapi.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$terapi = Terapi::findOrFail($id);

		return view('terapis.show', compact('terapi'));
	}

	/**
	 * Show the form for editing the specified terapi.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$terapi = Terapi::find($id);

		return view('terapis.edit', compact('terapi'));
	}

	/**
	 * Update the specified terapi in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$terapi = Terapi::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Terapi::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$terapi->update($data);

		return \Redirect::route('terapis.index');
	}

	/**
	 * Remove the specified terapi from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Terapi::destroy($id);

		return \Redirect::route('terapis.index');
	}

}
