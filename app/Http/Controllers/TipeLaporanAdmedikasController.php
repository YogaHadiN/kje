<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;
use App\Tipelaporanadmedika;

class TipeLaporanAdmedikasController extends Controller
{

	/**
	 * Display a listing of tipelaporanadmedikas
	 *
	 * @return Response
	 */
	public function index()
	{
		$tipelaporanadmedikas = Tipelaporanadmedika::all();

		return view('tipelaporanadmedikas.index', compact('tipelaporanadmedikas'));
	}

	/**
	 * Show the form for creating a new tipelaporanadmedika
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('tipelaporanadmedikas.create');
	}

	/**
	 * Store a newly created tipelaporanadmedika in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), Tipelaporanadmedika::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Tipelaporanadmedika::create($data);

		return \Redirect::route('tipelaporanadmedikas.index');
	}

	/**
	 * Display the specified tipelaporanadmedika.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$tipelaporanadmedika = Tipelaporanadmedika::findOrFail($id);

		return view('tipelaporanadmedikas.show', compact('tipelaporanadmedika'));
	}

	/**
	 * Show the form for editing the specified tipelaporanadmedika.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tipelaporanadmedika = Tipelaporanadmedika::find($id);

		return view('tipelaporanadmedikas.edit', compact('tipelaporanadmedika'));
	}

	/**
	 * Update the specified tipelaporanadmedika in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$tipelaporanadmedika = Tipelaporanadmedika::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Tipelaporanadmedika::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$tipelaporanadmedika->update($data);

		return \Redirect::route('tipelaporanadmedikas.index');
	}

	/**
	 * Remove the specified tipelaporanadmedika from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Tipelaporanadmedika::destroy($id);

		return \Redirect::route('tipelaporanadmedikas.index');
	}

}
