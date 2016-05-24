<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Approve;

class ApprovesController extends Controller
{

	/**
	 * Display a listing of approves
	 *
	 * @return Response
	 */
	public function index()
	{
		$approves = Approve::all();

		return view('approves.index', compact('approves'));
	}

	/**
	 * Show the form for creating a new approve
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('approves.create');
	}

	/**
	 * Store a newly created approve in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		Approve::create($data);

		return \Redirect::route('approves.index');
	}

	/**
	 * Display the specified approve.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$approve = Approve::findOrFail($id);

		return view('approves.show', compact('approve'));
	}

	/**
	 * Show the form for editing the specified approve.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$approve = Approve::find($id);

		return view('approves.edit', compact('approve'));
	}

	/**
	 * Update the specified approve in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$approve = Approve::findOrFail($id);


		$approve->update($data);

		return \Redirect::route('approves.index');
	}

	/**
	 * Remove the specified approve from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Approve::destroy($id);

		return \Redirect::route('approves.index');
	}

}
