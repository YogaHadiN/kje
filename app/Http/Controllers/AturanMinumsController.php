<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\AturanMinum;

class AturanMinumsController extends Controller
{

	/**
	 * Display a listing of aturanminums
	 *
	 * @return Response
	 */
	public function index()
	{
		$aturanminums = AturanMinum::all();

		return view('aturanminums.index', compact('aturanminums'));
	}

	/**
	 * Show the form for creating a new aturanminum
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('aturanminums.create');
	}

	/**
	 * Store a newly created aturanminum in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		AturanMinum::create($data);

		return \Redirect::route('aturanminums.index');
	}

	/**
	 * Display the specified aturanminum.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$aturanminum = AturanMinum::findOrFail($id);

		return view('aturanminums.show', compact('aturanminum'));
	}

	/**
	 * Show the form for editing the specified aturanminum.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$aturanminum = AturanMinum::find($id);

		return view('aturanminums.edit', compact('aturanminum'));
	}

	/**
	 * Update the specified aturanminum in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$aturanminum = AturanMinum::findOrFail($id);


		$aturanminum->update($data);

		return \Redirect::route('aturanminums.index');
	}

	/**
	 * Remove the specified aturanminum from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		AturanMinum::destroy($id);

		return \Redirect::route('aturanminums.index');
	}

}
