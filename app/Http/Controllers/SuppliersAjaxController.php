<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\FakturBelanja;

class SuppliersAjaxController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function ceknotalama()
	{
		$supplier_id = Input::get('supplier_id');
		$nomor_faktur = Input::get('nomor_faktur');

		$count = FakturBelanja::where('supplier_id', $supplier_id)
							->where('nomor_faktur', $nomor_faktur)
							->count();

		if ($count > 0) {
			return '1';
		} else {
			return '0';
		}
	}


}
