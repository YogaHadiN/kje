<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Tiperumahsakit;

class TipeRumahSakitsController extends Controller
{

	/**
	 * Display a listing of tiperumahsakits
	 *
	 * @return Response
	 */
	public function index()
	{
		$tiperumahsakits = Tiperumahsakit::all();

		return view('tiperumahsakits.index', compact('tiperumahsakits'));
	}

	/**
	 * Show the form for creating a new tiperumahsakit
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('tiperumahsakits.create');
	}

	/**
	 * Store a newly created tiperumahsakit in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), Tiperumahsakit::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Tiperumahsakit::create($data);

		return \Redirect::route('tiperumahsakits.index');
	}

	/**
	 * Display the specified tiperumahsakit.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$tiperumahsakit = Tiperumahsakit::findOrFail($id);

		return view('tiperumahsakits.show', compact('tiperumahsakit'));
	}

	/**
	 * Show the form for editing the specified tiperumahsakit.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tiperumahsakit = Tiperumahsakit::find($id);

		return view('tiperumahsakits.edit', compact('tiperumahsakit'));
	}

	/**
	 * Update the specified tiperumahsakit in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$tiperumahsakit = Tiperumahsakit::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Tiperumahsakit::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$tiperumahsakit->update($data);

		return \Redirect::route('tiperumahsakits.index');
	}

	/**
	 * Remove the specified tiperumahsakit from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Tiperumahsakit::destroy($id);

		return \Redirect::route('tiperumahsakits.index');
	}

}
