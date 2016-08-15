<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Reflekspatela;

class RefleksPatelasController extends Controller
{

	/**
	 * Display a listing of reflekspatelas
	 *
	 * @return Response
	 */
	public function index()
	{
		$reflekspatelas = Reflekspatela::all();

		return view('reflekspatelas.index', compact('reflekspatelas'));
	}

	/**
	 * Show the form for creating a new reflekspatela
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('reflekspatelas.create');
	}

	/**
	 * Store a newly created reflekspatela in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), Reflekspatela::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Reflekspatela::create($data);

		return \Redirect::route('reflekspatelas.index');
	}

	/**
	 * Display the specified reflekspatela.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$reflekspatela = Reflekspatela::findOrFail($id);

		return view('reflekspatelas.show', compact('reflekspatela'));
	}

	/**
	 * Show the form for editing the specified reflekspatela.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$reflekspatela = Reflekspatela::find($id);

		return view('reflekspatelas.edit', compact('reflekspatela'));
	}

	/**
	 * Update the specified reflekspatela in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$reflekspatela = Reflekspatela::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Reflekspatela::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$reflekspatela->update($data);

		return \Redirect::route('reflekspatelas.index');
	}

	/**
	 * Remove the specified reflekspatela from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Reflekspatela::destroy($id);

		return \Redirect::route('reflekspatelas.index');
	}

}
