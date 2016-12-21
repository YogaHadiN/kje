<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\TransaksiPeriksa;
use App\Periksa;
use Input;

class PeriksaCustomController extends Controller
{
	public function editJurnal($id){
		$periksa = Periksa::find($id);
		return view('jurnal_umums.editJurnal', compact('periksa'));
	}
	
	public function editTransaksiPeriksa($id){
		$tra = TransaksiPeriksa::where('periksa_id', $id)->get();
		$periksa = Periksa::find($id);
		
		return view('periksas.editTransaksiPeriksa', compact(
			'tra',
			'periksa'
		));
	}
	public function updateTransaksiPeriksa(){
		$id = Input::get('id');
		$nilai = Input::get('nilai');

		$t       = TransaksiPeriksa::find($id);
		$t->biaya   = Input::get('nilai');
		$confirm = $t->save();

		return $t->biaya;
	}
	public function updateTunai($id){
		$nilai = Input::get('nilai');

		$p       = Periksa::find($id);
		$p->tunai   = Input::get('nilai');
		$p->save();
		
		return $p->tunai;
	}
	
	public function updatePiutang($id){
		$nilai = Input::get('nilai');

		$p       = Periksa::find($id);
		$p->piutang   = Input::get('nilai');
		$p->save();
		
		return $p->piutang;
	}
	
}
