<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Statusgizi;

class StatusGizisController extends Controller
{

	/**
	 * Display a listing of statusgizis
	 *
	 * @return Response
	 */
	public function index()
	{
		$statusgizis = Statusgizi::all();

		return view('statusgizis.index', compact('statusgizis'));
	}

	/**
	 * Show the form for creating a new statusgizi
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('statusgizis.create');
	}

	/**
	 * Store a newly created statusgizi in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), Statusgizi::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Statusgizi::create($data);

		return \Redirect::route('statusgizis.index');
	}

	/**
	 * Display the specified statusgizi.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$statusgizi = Statusgizi::findOrFail($id);

		return view('statusgizis.show', compact('statusgizi'));
	}

	/**
	 * Show the form for editing the specified statusgizi.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$statusgizi = Statusgizi::find($id);

		return view('statusgizis.edit', compact('statusgizi'));
	}

	/**
	 * Update the specified statusgizi in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$statusgizi = Statusgizi::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Statusgizi::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$statusgizi->update($data);

		return \Redirect::route('statusgizis.index');
	}

	/**
	 * Remove the specified statusgizi from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Statusgizi::destroy($id);

		return \Redirect::route('statusgizis.index');
	}

}
