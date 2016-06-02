<?php

namespace App\Http\Controllers;

use Input;
use App\Classes\Yoga;

use App\Http\Requests;

use App\Pendapatan;
use App\JurnalUmum;

class PendapatansController extends Controller
{

	/**
	 * Display a listing of pendapatans
	 *
	 * @return Response
	 */
	public function index()
	{
		$pendapatans = Pendapatan::all();

		return view('pendapatans.index', compact('pendapatans'));
	}

	/**
	 * Show the form for creating a new pendapatan
	 *
	 * @return Response
	 */
	public function create()
	{
		// return 'create';
		return view('pendapatans.create');
	}

	/**
	 * Store a newly created pendapatan in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		$array = json_decode(Input::get('array'), true);
		$biaya = 0;
		foreach ($array as $key => $arr) {

			$pendapatan             = new Pendapatan;
			$pendapatan->pendapatan = $arr['pendapatan'];
			$pendapatan->biaya      = $arr['jumlah'];
			$pendapatan->staf_id    = $arr['staf_id'];
			$pendapatan->keterangan = $arr['keterangan'];
			$confirm                = $pendapatan->save();
			

			if ($confirm) {
				$jurnal                  = new JurnalUmum;
				$jurnal->jurnalable_id   = $pendapatan->id; // kenapa ini nilainya empty / null padahal di database ada id
				$jurnal->jurnalable_type = 'App\Pendapatan';
				$jurnal->coa_id          = 110000;
				$jurnal->debit           = 1;
				$jurnal->nilai           = $arr['jumlah'];
				$jurnal->save();

				$jurnal                  = new JurnalUmum;
				$jurnal->jurnalable_id   = $pendapatan->id;
				$jurnal->jurnalable_type = 'App\Pendapatan';
				$jurnal->debit           = 0;
				$jurnal->nilai           = $arr['jumlah'];
				$jurnal->save();
			}
		}
		return redirect('laporans')->withPesan(Yoga::suksesFlash('<strong>Pendapatan</strong> telah berhasil dimasukkan'));
	}

	/**
	 * Display the specified pendapatan.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$pendapatan = Pendapatan::findOrFail($id);

		return view('pendapatans.show', compact('pendapatan'));
	}

	/**
	 * Show the form for editing the specified pendapatan.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$pendapatan = Pendapatan::find($id);

		return view('pendapatans.edit', compact('pendapatan'));
	}

	/**
	 * Update the specified pendapatan in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$pendapatan = Pendapatan::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Pendapatan::$rules);

		if ($validator->fails())
		{
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$pendapatan->update($data);

		return \Redirect::route('pendapatans.index');
	}

	/**
	 * Remove the specified pendapatan from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Pendapatan::destroy($id);

		return \Redirect::route('pendapatans.index');
	}
    public function pembayaran_asuransi(){
         return 'pembayaran_asuransi';
    }
    public function pembayaran_asuransi_by_id($id){
        return 'asuransi '. $id;
         return 'pembayaran_asuransi';
    }
    
}
