<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Confirm;

class ConfirmsController extends Controller
{

	/**
	 * Display a listing of confirms
	 *
	 * @return Response
	 */
	public function index()
	{
		$confirms = Confirm::all();

		return view('confirms.index', compact('confirms'));
	}

	/**
	 * Show the form for creating a new confirm
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('confirms.create');
	}

	/**
	 * Store a newly created confirm in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		Confirm::create($data);

		return \Redirect::route('confirms.index');
	}

	/**
	 * Display the specified confirm.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$confirm = Confirm::findOrFail($id);

		return view('confirms.show', compact('confirm'));
	}

	/**
	 * Show the form for editing the specified confirm.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$confirm = Confirm::find($id);

		return view('confirms.edit', compact('confirm'));
	}

	/**
	 * Update the specified confirm in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$confirm = Confirm::findOrFail($id);


		$confirm->update($data);

		return \Redirect::route('confirms.index');
	}

	/**
	 * Remove the specified confirm from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Confirm::destroy($id);

		return \Redirect::route('confirms.index');
	}

}
