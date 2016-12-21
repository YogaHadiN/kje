<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Transaksiperiksa;

class TransaksiPeriksasController extends Controller
{

	/**
	 * Display a listing of transaksiperiksas
	 *
	 * @return Response
	 */
	public function index()
	{
		$transaksiperiksas = Transaksiperiksa::all();

		return view('transaksiperiksas.index', compact('transaksiperiksas'));
	}

	/**
	 * Show the form for creating a new transaksiperiksa
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('transaksiperiksas.create');
	}

	/**
	 * Store a newly created transaksiperiksa in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), Transaksiperiksa::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Transaksiperiksa::create($data);

		return \Redirect::route('transaksiperiksas.index');
	}

	/**
	 * Display the specified transaksiperiksa.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$transaksiperiksa = Transaksiperiksa::findOrFail($id);

		return view('transaksiperiksas.show', compact('transaksiperiksa'));
	}

	/**
	 * Show the form for editing the specified transaksiperiksa.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$transaksiperiksa = Transaksiperiksa::find($id);
		return view('transaksiperiksas.edit', compact('transaksiperiksa'));
	}

	/**
	 * Update the specified transaksiperiksa in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$transaksiperiksa = Transaksiperiksa::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Transaksiperiksa::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$transaksiperiksa->update($data);

		return \Redirect::route('transaksiperiksas.index');
	}

	/**
	 * Remove the specified transaksiperiksa from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Transaksiperiksa::destroy($id);

		return \Redirect::route('transaksiperiksas.index');
	}

}
