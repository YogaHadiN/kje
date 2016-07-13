<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\FakturBelanja;
use App\Supplier;

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

    public function create(){
        $nama = Input::get('nama');
        $alamat = Input::get('alamat');
        $hp_pic = Input::get('hp_pic');
        $pic = Input::get('pic');
        $no_telp = Input::get('no_telp');


        $sup = new Supplier;
        $sup->nama = $nama;
        $sup->alamat = $alamat;
        $sup->hp_pic = $hp_pic;
        $sup->pic = $pic;
        $sup->no_telp = $no_telp;
        $confirm = $sup->save();
        $options = [];
        $options[] = [
            'value' => null,
            'text' => '-Pilih-'
        ];
        $suppliers = Supplier::all();
        foreach ($suppliers as $supplier) {
            $options[] = [
                'value' => $supplier->id,
                'text' => $supplier->nama
            ];
        }
        if ($confirm) {
            $data = [
                'selected' => $sup->id,
                'options' => $options 
            ];
        } else {
            $data = [
                'selected' => '',
                'options' => ''
            ];
        }
        return json_encode( $data );
    }
    

}
