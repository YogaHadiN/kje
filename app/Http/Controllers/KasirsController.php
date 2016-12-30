<?php

namespace App\Http\Controllers;

use Input;
use App\Saldo;
use App\Classes\Yoga;
use App\Sms;
use App\Http\Controllers\PengeluaransController;

use App\Http\Requests;

use App\Periksa;

class KasirsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 * GET /kasirs
	 *
	 * @return Response
	 */
	public function index()
	{
		// return 'kasir koncto';

		$antriansurveys = Periksa::where('lewat_kasir', '1')->where('lewat_poli', '1')->where('lewat_kasir2', '0')->get();

		return view('surveys.index', compact('antriansurveys'));

	}

	public function saldo(){
		$saldos = Saldo::all();
		return view('kasirs.saldo', compact('saldos'));
	}
	
	public function saldoPost(){

		$rules = [
			'saldo' => 'required',
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}


		$saldo = Yoga::clean( Input::get('saldo') );
		$saldo_saat_ini = 0;
		$selisih = 0;

		$checkout = new PengeluaransController;
		$saldo_saat_ini = $checkout->parameterKasir()['uang_di_kasir'];

		$selisih = $saldo - $saldo_saat_ini;

		$sl                 = new Saldo;
		$sl->saldo          = $saldo;
		$sl->saldo_saat_ini = $saldo_saat_ini;
		$sl->selisih        = $selisih;
		$confirm = $sl->save();

		if ($selisih > 0) {
			Sms::send('081381912803', 'Ada selsih uang di kasir sebesar ' . Yoga::buatrp($selisih) . ' segera hitung dan cari dimana kesalahannya' );
			Sms::send('085721012351', 'Ada selsih uang di kasir sebesar ' . Yoga::buatrp($selisih) . ' segera hitung dan cari dimana kesalahannya' );
		}

		if ($confirm) {
			$pesan = Yoga::suksesFlash('Penghitungan Saldo <strong>BERHASIL</strong> dilakukan');
		} else {
			$pesan = Yoga::gagalFlash('Penghitungan Saldo <strong>GAGAL</strong> dilakukan');
		}
		return redirect()->back()->withPesan($pesan);
	}


}
