<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\SuratSakit;
use App\Periksa;
use DB;
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

		$query = "SELECT px.tanggal as tanggal_periksa, ";
		$query .= "ss.tanggal_mulai as tanggal_izin, ";
		$query .= "ss.hari as jumlah_hari, ";
		$query .= "st.nama as nama_staf, ";
		$query .= "asu.nama as pembayaran, ";
		$query .= "dg.diagnosa as diagnosa ";
		$query .= "FROM surat_sakits as ss join periksas as px on ss.periksa_id = px.id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "join stafs as st on px.staf_id = st.id ";
		$query .= "join diagnosas as dg on px.diagnosa_id = dg.id ";
		$query .= "join asuransis as asu on px.asuransi_id = asu.id ";
		$query .= "WHERE px.pasien_id = '{$periksa->pasien_id}' ";
		$query .= "ORDER BY px.created_at desc ";

		$ss = DB::select($query);

		return view('suratsakits.create', compact(
			'periksa',
			'ss'
		));
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
		$periksa = $suratsakit->periksa;

		$query = "SELECT px.tanggal as tanggal_periksa, ";
		$query .= "ss.tanggal_mulai as tanggal_izin, ";
		$query .= "ss.hari as jumlah_hari, ";
		$query .= "st.nama as nama_staf, ";
		$query .= "asu.nama as pembayaran, ";
		$query .= "dg.diagnosa as diagnosa ";
		$query .= "FROM surat_sakits as ss join periksas as px on ss.periksa_id = px.id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "join stafs as st on px.staf_id = st.id ";
		$query .= "join diagnosas as dg on px.diagnosa_id = dg.id ";
		$query .= "join asuransis as asu on px.asuransi_id = asu.id ";
		$query .= "WHERE px.pasien_id = '{$periksa->pasien_id}' ";
		$query .= "AND ss.id not like '{$id}'";
		$query .= "ORDER BY px.created_at desc ";

		$ss = DB::select($query);

		return view('suratsakits.edit', compact(
			'ss',
			'suratsakit'
		));
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
