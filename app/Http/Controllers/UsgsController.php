<?php


namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Usg;
use App\Periksa;

class UsgsController extends Controller
{

	/**
	 * Display a listing of usgs
	 *
	 * @return Response
	 */
	public function index()
	{
		$usgs = Usg::all();

		return view('usgs.index', compact('usgs'));
	}

	/**
	 * Show the form for creating a new usg
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('usgs.create');
	}

	/**
	 * Store a newly created usg in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make($data = Input::all(), Usg::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		Usg::create($data);

		return \Redirect::route('usgs.index');
	}

	/**
	 * Display the specified usg.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$periksa = Periksa::findOrFail($id);

		return view('usgs.show', compact('periksa'));
	}

	/**
	 * Show the form for editing the specified usg.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$usg = Usg::find($id);

		return view('usgs.edit', compact('usg'));
	}

	/**
	 * Update the specified usg in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$usg = Usg::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Usg::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$usg->update($data);

		return \Redirect::route('usgs.index');
	}

	/**
	 * Remove the specified usg from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Usg::destroy($id);

		return \Redirect::route('usgs.index');
	}

}
