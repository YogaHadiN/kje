<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Perbaikantrx;
use App\Classes\Yoga;

class PerbaikantrxsController extends Controller
{

	/**
	 * Display a listing of perbaikantrxs
	 *
	 * @return Response
	 */
	public function index()
	{
		$perbaikans = Perbaikantrx::orderBy('id', 'desc')->paginate(10);

		return view('perbaikantrxs.index', compact('perbaikans'));
	}

	/**
	 * Show the form for creating a new perbaikantrx
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('perbaikantrxs.create');
	}

	/**
	 * Store a newly created perbaikantrx in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), Perbaikantrx::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Perbaikantrx::create($data);

		return \Redirect::route('perbaikantrxs.index');
	}

	/**
	 * Display the specified perbaikantrx.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{
		$mulai = Yoga::datePrep(Input::get('mulai'));
		$akhir = Yoga::datePrep(Input::get('akhir'));

		$perbaikans = Perbaikantrx::whereRaw("created_at between '{$mulai} 00:00:00' and '{$akhir} 23:59:59'")->orderBy('id', 'desc')->paginate(20);

		return view('perbaikantrxs.show', compact('perbaikans', 'mulai', 'akhir'));
	}

	/**
	 * Show the form for editing the specified perbaikantrx.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$perbaikantrx = Perbaikantrx::find($id);

		return view('perbaikantrxs.edit', compact('perbaikantrx'));
	}

	/**
	 * Update the specified perbaikantrx in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$perbaikantrx = Perbaikantrx::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Perbaikantrx::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$perbaikantrx->update($data);

		return \Redirect::route('perbaikantrxs.index');
	}

	/**
	 * Remove the specified perbaikantrx from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Perbaikantrx::destroy($id);

		return \Redirect::route('perbaikantrxs.index');
	}

}
