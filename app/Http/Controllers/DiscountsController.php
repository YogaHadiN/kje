<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use App\Http\Requests;
use App\Models\Promo;
use App\Models\Asuransi;
use App\Models\DiscountAsuransi;
use App\Models\Classes\Yoga;
use App\Models\Tarif;
use App\Models\JenisTarif;

class DiscountsController extends Controller
{
	public function __construct()
	{
		$this->middleware('admin', ['except' => []]);
	}

	public function promoKtpPertahunPost(){
		$rules = [
			'no_ktp' => 'required',
			'poli_id'   => 'required',
			'tahun'  => 'required'
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$p          = new Promo;
		$p->no_ktp  = Input::get('no_ktp');
		$p->poli_id = Input::get('poli_id');
		$p->tahun   = Input::get('tahun');
		$confirm    = $p->save();

		if ($confirm) {
			$pesan = Yoga::suksesFlash('Promo telah <strong>BERHASIL</strong> Dimasukkan');
		} else {
			$pesan = Yoga::gagalFlash('Promo telah <strong>GAGAL</strong> Dimasukkan');
		}
		return redirect('redirectUrl')->back()->withPesan($pesan);
	}
	
	
}
