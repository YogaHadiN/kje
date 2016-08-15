<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\JenisTarif;

class JenisTarifsController extends Controller
{

	/**
	 * Display a listing of jenistarifs
	 *
	 * @return Response
	 */
	public function index()
	{
		$jenistarifs = JenisTarif::all();

		return view('jenistarifs.index', compact('jenistarifs'));
	}

	/**
	 * Show the form for creating a new jenistarif
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('jenistarifs.create');
	}

	/**
	 * Store a newly created jenistarif in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), JenisTarif::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		JenisTarif::create($data);

		return \Redirect::route('jenistarifs.index');
	}

	/**
	 * Display the specified jenistarif.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$jenistarif = JenisTarif::findOrFail($id);

		return view('jenistarifs.show', compact('jenistarif'));
	}

	/**
	 * Show the form for editing the specified jenistarif.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$jenistarif = JenisTarif::find($id);

		return view('jenistarifs.edit', compact('jenistarif'));
	}

	/**
	 * Update the specified jenistarif in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$jenistarif = JenisTarif::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), JenisTarif::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$jenistarif->update($data);

		return \Redirect::route('jenistarifs.index');
	}

	/**
	 * Remove the specified jenistarif from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		JenisTarif::destroy($id);

		return \Redirect::route('jenistarifs.index');
	}

}
