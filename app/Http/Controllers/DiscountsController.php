<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use App\Http\Requests;
use App\Models\Discount;
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

	public function index(){
		$discounts = Discount::with('discountAsuransi')->get();
		$jumlahAsuransi = Asuransi::count();
		return view('discounts.index', compact(
			'jumlahAsuransi',
			'discounts'
		));
	}
	public function create(){
		$jenisTarifList = [ null => '-Pilih-' ] + JenisTarif::pluck('jenis_tarif', 'id')->all();
		return view('discounts.create', compact('jenisTarifList'));
	}
	public function delete($id){
		$discount = Discount::with('jenisTarif')->where('id', $id)->first();
		$jenisTarif = $discount->jenisTarif->jenis_tarif;
		$diskon_persen = $discount->diskon_persen;
		$confirm = Discount::destroy($id);
		if ($confirm) {
			$pesan = Yoga::suksesFlash('Diskon '  . $jenisTarif . ' sebesar ' . $diskon_persen. ' <strong>BERHASIL</strong> Dihapus');
		} else {
			$pesan = Yoga::gagalFlash('Diskon '  . $jenisTarif . ' sebesar ' . $diskon_persen. ' <strong>GAGAL</strong> Dihapus ');
		}
		return redirect('discounts')->withPesan($pesan);
	}

	public function edit($id){
		$jenisTarifList    = [ null => '-Pilih-' ] + JenisTarif::pluck('jenis_tarif', 'id')->all();
		$discount          = Discount::find($id);
		$discAsuransis     = $discount->discountAsuransi;
		$asuransis         = [];
		foreach ($discAsuransis as $d) {
			$asuransis[]   = $d->asuransi_id;
		}
		return view('discounts.edit', compact(
			'jenisTarifList',
			'asuransis',
			'discount'
		));
	}
	public function update($id){
		$d                 = Discount::find($id);
		$d->jenis_tarif_id = Input::get('jenis_tarif_id');
		$d->diskon_persen  = Input::get('diskon_persen');
		$d->dimulai        = Yoga::datePrep( Input::get('dimulai') );
		$d->berakhir       = Yoga::datePrep( Input::get('berakhir'));
		$d->save();

		$da = DiscountAsuransi::where('discount_id', $id)->delete();
		if ($da) {
			$data = [];
			$timestamp = date('Y-m-d H:i:s');
			foreach ( Input::get('asuransi_id') as $v) {
				$data[]            = [
					'discount_id' => $d->id,
					'asuransi_id' => $v,
							'tenant_id'  => session()->get('tenant_id'),
					'created_at'  => $timestamp,
					'updated_at'  => $timestamp
				];
			}
			DiscountAsuransi::insert($data);
		}
		$pesan = Yoga::suksesFlash('Update discount ' . $d->jenisTarif->jenis_tarif . ' telah berhasil');
		return redirect('discounts')->withPesan($pesan);
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
							'tenant_id'  => session()->get('tenant_id'),
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
	public function promoKtpPertahun(){
		$promos = Promo::all();
		return view('discounts.promoKtpPerTahun', compact('promos'));
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

		$p         = new Promo;
		$p->no_ktp = Input::get('no_ktp');
		$p->poli_id   = Input::get('poli_id');
		$p->tahun  = Input::get('tahun');
		$confirm   = $p->save();

		if ($confirm) {
			$pesan = Yoga::suksesFlash('Promo telah <strong>BERHASIL</strong> Dimasukkan');
		} else {
			$pesan = Yoga::gagalFlash('Promo telah <strong>GAGAL</strong> Dimasukkan');
		}
		return redirect('redirectUrl')->back()->withPesan($pesan);
	}
	
	
}
