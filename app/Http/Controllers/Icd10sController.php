<?php



namespace App\Http\Controllers;

use Input;

use App\Http\Requests;


use App\Icd10;


class Icd10sController extends Controller
{

	/**
	 * Display a listing of icd10s
	 *
	 * @return Response
	 */
	public function index()
	{
		$icd10s = Icd10::all();

		return view('icd10s.index', compact('icd10s'));
	}

	/**
	 * Show the form for creating a new icd10
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('icd10s.create');
	}

	/**
	 * Store a newly created icd10 in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), Icd10::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Icd10::create($data);

		return \Redirect::route('icd10s.index');
	}

	/**
	 * Display the specified icd10.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$icd10 = Icd10::findOrFail($id);

		return view('icd10s.show', compact('icd10'));
	}

	/**
	 * Show the form for editing the specified icd10.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$icd10 = Icd10::find($id);

		return view('icd10s.edit', compact('icd10'));
	}

	/**
	 * Update the specified icd10 in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$icd10 = Icd10::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Icd10::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$icd10->update($data);

		return \Redirect::route('icd10s.index');
	}

	/**
	 * Remove the specified icd10 from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Icd10::destroy($id);

		return \Redirect::route('icd10s.index');
	}

}
