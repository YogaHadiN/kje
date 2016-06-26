<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Supplier;
use App\Classes\Yoga;
use App\Belanja;
use App\FakturBelanja;
class SupplierBelanjasController extends Controller
{
    public function belanja_obat(){
		$suppliers = Supplier::all();
		$stafs = Yoga::stafList();
        $fakturbelanjas = FakturBelanja::where('belanja_id', 1)->latest()->get();
		$belanjaList = [ null => '- Jenis Belanja -']  + Belanja::lists('belanja', 'id')->all();
		return view('suppliers.belanja_obat', compact('suppliers', 'stafs', 'belanjaList', 'fakturbelanjas'));
    }
    public function belanja_bukan_obat(){
		$suppliers = Supplier::all();
		$stafs = Yoga::stafList();
        $fakturbelanjas = FakturBelanja::where('belanja_id', 3)->latest()->get();
		$belanjaList = [ null => '- Jenis Belanja -']  + Belanja::lists('belanja', 'id')->all();
		return view('suppliers.belanja_bukan_obat', compact('suppliers', 'stafs', 'belanjaList', 'fakturbelanjas'));
    }
}
