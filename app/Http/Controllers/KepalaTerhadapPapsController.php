<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Kepalaterhadappap;


class KepalaTerhadapPapsController extends Controller
{

	/**
	 * Display a listing of kepalaterhadappaps
	 *
	 * @return Response
	 */
	public function index()
	{
		$kepalaterhadappaps = Kepalaterhadappap::all();

		return view('kepalaterhadappaps.index', compact('kepalaterhadappaps'));
	}

	/**
	 * Show the form for creating a new kepalaterhadappap
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('kepalaterhadappaps.create');
	}

	/**
	 * Store a newly created kepalaterhadappap in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), Kepalaterhadappap::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Kepalaterhadappap::create($data);

		return \Redirect::route('kepalaterhadappaps.index');
	}

	/**
	 * Display the specified kepalaterhadappap.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$kepalaterhadappap = Kepalaterhadappap::findOrFail($id);

		return view('kepalaterhadappaps.show', compact('kepalaterhadappap'));
	}

	/**
	 * Show the form for editing the specified kepalaterhadappap.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$kepalaterhadappap = Kepalaterhadappap::find($id);

		return view('kepalaterhadappaps.edit', compact('kepalaterhadappap'));
	}

	/**
	 * Update the specified kepalaterhadappap in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$kepalaterhadappap = Kepalaterhadappap::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Kepalaterhadappap::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$kepalaterhadappap->update($data);

		return \Redirect::route('kepalaterhadappaps.index');
	}

	/**
	 * Remove the specified kepalaterhadappap from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Kepalaterhadappap::destroy($id);

		return \Redirect::route('kepalaterhadappaps.index');
	}

}
