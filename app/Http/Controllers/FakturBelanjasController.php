<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\FakturBelanja;
use App\Classes\Yoga;


class FakturBelanjasController extends Controller
{

	/**
	 * Display a listing of the resource.
	 * GET /fakturbelanjas
	 *
	 * @return Response
	 */
	public function index()
	{
		$fakturbelanjas = FakturBelanja::where('submit', '0')->get();
		$stafs = Yoga::staflist();
		$suppliers = Yoga::supplierList();
		return view('fakturbelanjas.index', compact('fakturbelanjas', 'stafs', 'suppliers'));
	}
	public function cari(){
		$fakturbelanjas = FakturBelanja::where('submit', '1')->latest()->get();
		return view('fakturbelanjas.cari', compact('fakturbelanjas'));
	}

	public function store(){
		$rules = [
			'tanggal' => 'required',
			'nomor_faktur' => 'required',
			'belanja_id' => 'required',
			'supplier_id' => 'required',
		];
		$validator = \Validator::make($data = Input::all(), $rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		$count = FakturBelanja::where('supplier_id', Input::get('supplier_id'))
					->where('nomor_faktur', Input::get('nomor_faktur'))
					->where('tanggal', Yoga::datePrep(Input::get('tanggal')))
					->first();
		if (count($count) > 0) {
			$faktur = $count;
			$faktur->submit = '0';
			$faktur->save();
		} else {
			$faktur = new FakturBelanja;
			$faktur->tanggal = Yoga::datePrep(Input::get('tanggal'));
			$faktur->nomor_faktur = Input::get('nomor_faktur');
			$faktur->belanja_id = Input::get('belanja_id');
			$faktur->supplier_id = Input::get('supplier_id');
			$faktur->save();
		}
		return redirect('fakturbelanjas')->withPesan(Yoga::suksesFlash('<strong>Faktur Baru</strong> berhasil dibuat'));
	}


	public function destroy($id){

		$faktur = FakturBelanja::find($id);
		$supplier = $faktur->supplier->nama;
		$confirm = $faktur->delete();

		return redirect('fakturbelanjas')->withPesan(Yoga::suksesFlash('Faktur Belanja di <strong>' . $supplier . '</strong> berhasil dihapus'));
	

	}

	

}
