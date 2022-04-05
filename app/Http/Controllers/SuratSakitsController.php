<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Models\SuratSakit;
use App\Models\Periksa;
use App\Models\PoliAntrian;
use App\Models\Classes\Yoga;
use DB;

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
	public function create($id, $jenis_antrian_id)
	{	
		$periksa                        = Periksa::find($id);
		$ss                             = $this->querySuratSakit($periksa);
		$dikasih_dalam_1_bulan_terakhir = $this->dikasiDalam1BulanTerakhir($periksa->pasien_id);

		return view('suratsakits.create', compact(
			'periksa',
			'jenis_antrian_id',
			'dikasih_dalam_1_bulan_terakhir',
			'ss'
		));
	}

	/**
	 * Store a newly created suratsakit in storage.
	 *
	 * @return Response
	 */
	public function store($poli)
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
		$periksa = Periksa::find(Input::get('periksa_id'));

		$ss                = new SuratSakit;
		$ss->periksa_id    = Input::get('periksa_id');
		$ss->tanggal_mulai = Yoga::datePrep(Input::get('tanggal_mulai'));
		$ss->hari          = Input::get('hari');
		$ss->save();	

		return redirect('ruangperiksa/' . $this->jenis_antrian_id($poli))->withPesan(Yoga::suksesFlash('Surat Sakit Untuk <strong>' .$periksa->pasien_id. ' - ' .$periksa->pasien->nama. '</strong> Berhasil Dibuat selama <strong>' .Input::get('hari'). ' Hari </strong>mulai tanggal <strong>' .Input::get('tanggal_mulai').  '</strong>'));
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
	public function edit($id, $poli)
	{
		$suratsakit                     = SuratSakit::find($id);
		$periksa                        = $suratsakit->periksa;
		$ss                             = $this->querySuratSakit($periksa);
		$dikasih_dalam_1_bulan_terakhir = $this->dikasiDalam1BulanTerakhir($periksa->pasien_id);
		$poli                           = $this->poli($poli);

		return view('suratsakits.edit', compact(
			'periksa',
			'poli',
			'dikasih_dalam_1_bulan_terakhir',
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
	public function update($id, $poli)
	{
		$validator = \Validator::make($data = Input::all(), SuratSakit::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}


		$ss                = SuratSakit::with('periksa.antrian', 'periksa.pasien')->where('id',$id)->first();
		$ss->periksa_id    = Input::get('periksa_id');
		$ss->tanggal_mulai = Yoga::datePrep(Input::get('tanggal_mulai'));
		$ss->hari          = Input::get('hari');
		$ss->save();

		return redirect('ruangperiksa/' . $this->jenis_antrian_id($poli))->withPesan(Yoga::suksesFlash('Surat Sakit <strong>' .$ss->periksa->pasien_id. ' - ' .$ss->periksa->pasien->nama. '</strong> berhasil <strong>DIUBAH</strong>'));
	}

	/**
	 * Remove the specified suratsakit from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, $poli)
	{
		$suratsakit       = SuratSakit::with('periksa.antrian', 'periksa.pasien')->where('id',$id)->first();
		$periksa_id       = $suratsakit->periksa_id;
		$nama_pasien      = $suratsakit->periksa->pasien->nama;
		$jenis_antrian_id = '6';
		if (!is_null($suratsakit->antrian)) {
			$jenis_antrian_id = $suratsakit->antrian->jenis_antrian_id;	
		}
		$suratsakit->delete();
		return redirect('ruangperiksa/' . $this->jenis_antrian_id($poli))->withPesan(Yoga::suksesFlash('Surat Sakit untuk <strong>' .$periksa_id. ' - ' .$nama_pasien. '</strong> berhasil dihapus'));
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function querySuratSakit($periksa)
	{
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

		return DB::select($query);
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	public function dikasiDalam1BulanTerakhir($pasien_id)
	{
		$today = date('Y-m-d');
		$query = "SELECT * ";
		$query .= "FROM surat_sakits as ss join periksas as px on ss.periksa_id = px.id ";
		$query .= "WHERE px.pasien_id = '{$pasien_id}' ";
		$query .= "AND px.tanggal between DATE_SUB(curdate(), INTERVAL 30 day) and curdate() ";
		$query .= "AND px.tanggal not like '{$today}'";
		$query .= "AND px.asuransi_id = 32;";

		/* $dikasih_dalam_2_bulan_terakhir = count(DB::select($query)); */
		return count(DB::select($query));
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	public function jenis_antrian_id($poli)
	{
		$poli = str_replace('_', ' ', $poli);
		$poli_antrian = PoliAntrian::where('poli_id',$poli)->first();

		if (!is_null($poli_antrian)) {
			$jenis_antrian_id = $poli_antrian->jenis_antrian_id;
		} else {
			$jenis_antrian_id = '5';
		}
		return $jenis_antrian_id;
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	public function poli($poli)
	{
		return str_replace(' ', '_', $poli);
	}
	
	
	
	

}
