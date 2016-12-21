<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\TransaksiPeriksa;
use Input;

class PeriksaCustomController extends Controller
{
	public function editJurnal($id){
		$periksa = Periksa::find($id);
		return view('jurnal_umums.editJurnal', compact('periksa'));
	}
	
	public function editTransaksiPeriksa($id){
		$tra = TransaksiPeriksa::where('periksa_id', $id)->get();
		return view('periksas.editTransaksiPeriksa', compact('tra'));
	}
	public function updateTransaksiPeriksa(){
		$id = Input::get('id');
		$nilai = Input::get('nilai');

		$t       = TransaksiPeriksa::find($id);
		$t->biaya   = Input::get('nilai');
		$confirm = $t->save();

		return $t->biaya;
	}
	
}
