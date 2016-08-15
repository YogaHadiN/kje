<?php




namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Transaksi;

class TransaksisController extends Controller
{

	/**
	 * Display a listing of transaksis
	 *
	 * @return Response
	 */
	public function index()
	{
		$transaksis = Transaksi::all();

		return view('transaksis.index', compact('transaksis'));
	}

	/**
	 * Show the form for creating a new transaksi
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('transaksis.create');
	}

	/**
	 * Store a newly created transaksi in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), Transaksi::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Transaksi::create($data);

		return \Redirect::route('transaksis.index');
	}

	/**
	 * Display the specified transaksi.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$transaksi = Transaksi::findOrFail($id);

		return view('transaksis.show', compact('transaksi'));
	}

	/**
	 * Show the form for editing the specified transaksi.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$transaksi = Transaksi::find($id);

		return view('transaksis.edit', compact('transaksi'));
	}

	/**
	 * Update the specified transaksi in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$transaksi = Transaksi::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Transaksi::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$transaksi->update($data);

		return \Redirect::route('transaksis.index');
	}

	/**
	 * Remove the specified transaksi from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Transaksi::destroy($id);

		return \Redirect::route('transaksis.index');
	}

}
