<?php


namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Komposisi;

class KomposisisController extends Controller
{

	/**
	 * Display a listing of komposisis
	 *
	 * @return Response
	 */
	public function index()
	{
		$komposisis = Komposisi::all();

		return view('komposisis.index', compact('komposisis'));
	}

	/**
	 * Show the form for creating a new komposisi
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('komposisis.create');
	}

	/**
	 * Store a newly created komposisi in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), Komposisi::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Komposisi::create($data);

		return \Redirect::route('komposisis.index');
	}

	/**
	 * Display the specified komposisi.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$komposisi = Komposisi::findOrFail($id);

		return view('komposisis.show', compact('komposisi'));
	}

	/**
	 * Show the form for editing the specified komposisi.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$komposisi = Komposisi::find($id);

		return view('komposisis.edit', compact('komposisi'));
	}

	/**
	 * Update the specified komposisi in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$komposisi = Komposisi::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Komposisi::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$komposisi->update($data);

		return \Redirect::route('komposisis.index');
	}

	/**
	 * Remove the specified komposisi from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Komposisi::destroy($id);

		return \Redirect::route('komposisis.index');
	}

}
