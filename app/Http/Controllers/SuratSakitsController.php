<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\SuratSakit;
use App\Periksa;
use App\Classes\Yoga;

class SuratSakitsController extends Controller
{

	/**
	 * Display a listing of suratsakits
	 *
	 * @return Response
	 */
	public function index()
	{
		$suratsakits = SuratSakit::all();

		return view('suratsakits.index', compact('suratsakits'));
	}

	/**
	 * Show the form for creating a new suratsakit
	 *
	 * @return Response
	 */
	public function create($id)
	{	
		$periksa = Periksa::find($id);
		return view('suratsakits.create', compact('periksa'));
	}

	/**
	 * Store a newly created suratsakit in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// return Input::all();
		$rules = [
			'tanggal_mulai' => 'required',
			'hari' => 'required|numeric'
		];
		$validator = \Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		// return Input::all();
		$periksa = Periksa::find(Input::get('periksa_id'));

		$ss = new SuratSakit;
		$ss->periksa_id = Input::get('periksa_id');
		$ss->tanggal_mulai = Yoga::datePrep(Input::get('tanggal_mulai'));
		$ss->hari = Input::get('hari');
		$ss->save();	

		return redirect('ruangperiksa/' . $periksa->poli)->withPesan(Yoga::suksesFlash('Surat Sakit Untuk <strong>' .$periksa->pasien_id. ' - ' .$periksa->pasien->nama. '</strong> Berhasil Dibuat selama <strong>' .Input::get('hari'). ' Hari </strong>mulai tanggal <strong>' .Input::get('tanggal_mulai').  '</strong>'));
	}

	/**
	 * Display the specified suratsakit.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$suratsakit = SuratSakit::findOrFail($id);

		return view('suratsakits.show', compact('suratsakit'));
	}

	/**
	 * Show the form for editing the specified suratsakit.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$suratsakit = SuratSakit::find($id);

		return view('suratsakits.edit', compact('suratsakit'));
	}

	/**
	 * Update the specified suratsakit in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$suratsakit = SuratSakit::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), SuratSakit::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$ss = SuratSakit::find($id);
		$ss->periksa_id = Input::get('periksa_id');
		$ss->tanggal_mulai = Yoga::datePrep(Input::get('tanggal_mulai'));
		$ss->hari = Input::get('hari');
		$ss->save();

		return redirect('ruangperiksa/' . $suratsakit->periksa->poli)->withPesan(Yoga::suksesFlash('Surat Sakit <strong>' .$suratsakit->periksa->pasien_id. ' - ' .$suratsakit->periksa->pasien->nama. '</strong> berhasil <strong>DIUBAH</strong>'));
	}

	/**
	 * Remove the specified suratsakit from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$suratsakit = SuratSakit::find($id);
		$periksa = $suratsakit->periksa;
		$suratsakit->delete();

		return redirect('ruangperiksa/' . $periksa->poli)->withPesan(Yoga::suksesFlash('Surat Sakit untuk <strong>' .$periksa->id. ' - ' .$periksa->pasien->nama. '</strong> berhasil dihapus'));
	}

}
