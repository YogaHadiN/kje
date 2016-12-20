<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Discount;
use App\Asuransi;
use App\DiscountAsuransi;
use App\Classes\Yoga;
use App\Tarif;
use Input;
use App\JenisTarif;

class DiscountsController extends Controller
{
	public function index(){
		$discounts = Discount::with('discountAsuransi')->get();
		$jumlahAsuransi = Asuransi::count();
		return view('discounts.index', compact(
			'jumlahAsuransi',
			'discounts'
		));
	}
	public function create(){
		$jenisTarifList = [ null => '-Pilih-' ] + JenisTarif::lists('jenis_tarif', 'id')->all();
		return view('discounts.create', compact('jenisTarifList'));
	}
	public function store(){


		$rules = [
			'jenis_tarif_id' => 'required',
			'asuransi_id'    => 'required',
			'diskon_persen'  => 'required',
			'dimulai'        => 'required',
			'berakhir'       => 'required',
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$d                 = new Discount;
		$d->jenis_tarif_id = Input::get('jenis_tarif_id');
		$d->diskon_persen  = Input::get('diskon_persen');
		$d->dimulai        = Yoga::datePrep(Input::get('dimulai'));
		$d->berakhir       = Yoga::datePrep(Input::get('berakhir'));
		$confirm           = $d->save();
		if ($confirm) {
			$data = [];
			$timestamp = date('Y-m-d H:i:s');
			foreach ( Input::get('asuransi_id') as $v) {
				$data[]            = [
					'discount_id' => $d->id,
					'asuransi_id' => $v,
					'created_at'  => $timestamp,
					'updated_at'  => $timestamp
				];
			}
			DiscountAsuransi::insert($data);
		}

		if ($confirm) {
			$pesan = Yoga::suksesFlash('Input Data Diskon telah Berhasil');
		} else {
			$pesan = Yoga::gagalFlash('Input Data Diskon telah Gagal');
		}
		return redirect('discounts')->withPesan($pesan);
	}
}
