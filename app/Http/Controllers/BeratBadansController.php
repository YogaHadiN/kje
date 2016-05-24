	<?php


namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\BeratBadan;

class BeratBadansController extends Controller
{

	/**
	 * Display a listing of beratbadans
	 *
	 * @return Response
	 */
	public function index()
	{
		$beratbadans = BeratBadan::all();

		return view('beratbadans.index', compact('beratbadans'));
	}

	/**
	 * Show the form for creating a new beratbadan
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('beratbadans.create');
	}

	/**
	 * Store a newly created beratbadan in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		BeratBadan::create($data);

		return \Redirect::route('beratbadans.index');
	}

	/**
	 * Display the specified beratbadan.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$beratbadan = BeratBadan::findOrFail($id);

		return view('beratbadans.show', compact('beratbadan'));
	}

	/**
	 * Show the form for editing the specified beratbadan.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$beratbadan = BeratBadan::find($id);

		return view('beratbadans.edit', compact('beratbadan'));
	}

	/**
	 * Update the specified beratbadan in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$beratbadan = BeratBadan::findOrFail($id);


		$beratbadan->update($data);

		return \Redirect::route('beratbadans.index');
	}

	/**
	 * Remove the specified beratbadan from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		BeratBadan::destroy($id);

		return \Redirect::route('beratbadans.index');
	}

}
