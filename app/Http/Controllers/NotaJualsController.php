<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\FakturBeli;
use App\Classes\Yoga;
use App\Supplier;

class NotaJualsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 * GET /notajuals
	 *
	 * @return Response
	 */
public function index()
	{
		$faktur_belis = FakturBeli::where('submit', '0')->get();
		$suppliers = Yoga::supplierList();

		return view('faktur_belis.index', compact('faktur_belis', 'suppliers'));
	}

	/**
	 * Show the form for creating a new fakturbeli
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('faktur_belis.create');
	}

	/**
	 * Store a newly created fakturbeli in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		if (Input::ajax()) {

			$fb = new Fakturbeli;
			$fb->id = Yoga::customId('App\Fakturbeli');
			$fb->supplier_id = Input::get('supplier_id');
			$fb->nomor_faktur = Input::get('nomor_faktur');
			$fb->submit = "0";
			$fb->tanggal = Yoga::datePrep(Input::get('tanggal'));
			$confirm = $fb->save();

			$supplier = Supplier::find($fb->supplier_id)->nama;
			$id = Fakturbeli::orderBy('id', 'desc')->get()->first()->id;

			$data = [	
				'id' => $id,
				'supplier' => $supplier,
				'nomor_faktur' => $fb->nomor_faktur,
				'tanggal' => $fb->tanggal
			];
		}

		if($confirm){
			return json_encode($data);
		}

		return null;
	}

	/**
	 * Display the specified fakturbeli.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$fakturbeli = Fakturbeli::findOrFail($id);

		return view('faktur_belis.show', compact('fakturbeli'));
	}

	/**
	 * Show the form for editing the specified fakturbeli.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$fakturbeli = Fakturbeli::find($id);

		return view('faktur_belis.edit', compact('fakturbeli'));
	}

	/**
	 * Update the specified fakturbeli in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$fakturbeli = Fakturbeli::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Fakturbeli::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$fakturbeli->update($data);

		return \Redirect::route('faktur_belis.index');
	}

	/**
	 * Remove the specified fakturbeli from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Fakturbeli::destroy($id);

		return \Redirect::route('faktur_belis.index');
	}

}