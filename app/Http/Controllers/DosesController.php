<?php



namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Dose;

class DosesController extends Controller
{

	/**
	 * Display a listing of doses
	 *
	 * @return Response
	 */
	public function index()
	{
		$doses = Dose::all();

		return view('doses.index', compact('doses'));
	}

	/**
	 * Show the form for creating a new dose
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('doses.create');
	}

	/**
	 * Store a newly created dose in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		Dose::create($data);

		return \Redirect::route('doses.index');
	}

	/**
	 * Display the specified dose.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$dose = Dose::findOrFail($id);

		return view('doses.show', compact('dose'));
	}

	/**
	 * Show the form for editing the specified dose.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$dose = Dose::find($id);

		return view('doses.edit', compact('dose'));
	}

	/**
	 * Update the specified dose in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$dose = Dose::findOrFail($id);

		$dose->update($data);

		return \Redirect::route('doses.index');
	}

	/**
	 * Remove the specified dose from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Dose::destroy($id);

		return \Redirect::route('doses.index');
	}

}
