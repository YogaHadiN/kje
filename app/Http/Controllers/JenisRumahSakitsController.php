<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Jenisrumahsakit;

class JenisRumahSakitsController extends Controller
{

	/**
	 * Display a listing of jenisrumahsakits
	 *
	 * @return Response
	 */
	public function index()
	{
		$jenisrumahsakits = Jenisrumahsakit::all();

		return view('jenisrumahsakits.index', compact('jenisrumahsakits'));
	}

	/**
	 * Show the form for creating a new jenisrumahsakit
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('jenisrumahsakits.create');
	}

	/**
	 * Store a newly created jenisrumahsakit in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), Jenisrumahsakit::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Jenisrumahsakit::create($data);

		return \Redirect::route('jenisrumahsakits.index');
	}

	/**
	 * Display the specified jenisrumahsakit.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$jenisrumahsakit = Jenisrumahsakit::findOrFail($id);

		return view('jenisrumahsakits.show', compact('jenisrumahsakit'));
	}

	/**
	 * Show the form for editing the specified jenisrumahsakit.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$jenisrumahsakit = Jenisrumahsakit::find($id);

		return view('jenisrumahsakits.edit', compact('jenisrumahsakit'));
	}

	/**
	 * Update the specified jenisrumahsakit in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$jenisrumahsakit = Jenisrumahsakit::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Jenisrumahsakit::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$jenisrumahsakit->update($data);

		return \Redirect::route('jenisrumahsakits.index');
	}

	/**
	 * Remove the specified jenisrumahsakit from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Jenisrumahsakit::destroy($id);

		return \Redirect::route('jenisrumahsakits.index');
	}

}
