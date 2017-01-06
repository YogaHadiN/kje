<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Sediaan;
use App\Classes\Yoga;
use Input;

class SediaansController extends Controller
{
	public function index(){
		$sediaans = Sediaan::all();
		return view('sediaans.index', compact('sediaans'));
	}
	public function create(){
		return view('sediaans.create', compact(''));
	}
	
	public function store(){
		$rules = [
			'sediaan' => 'required|unique:sediaans',
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$sediaan       = new Sediaan;
		$sediaan->id   = Input::get('sediaan');
		$sediaan->sediaan   = Input::get('sediaan');
		$confirm = $sediaan->save();
		if ($confirm) {
			$pesan = Yoga::suksesFlash('Sediaan Baru '  . $sediaan->sediaan . ' <strong>BERHASIL</strong> Dibuat');
		} else {
			$pesan = Yoga::gagalFlash('Sediaan Baru '  . $sediaan->sediaan . ' <strong>GAGAL</strong> Dibuat');
		}

		return redirect('sediaans')->withPesan($pesan);
	}

	public function destroy($id){
		$sediaan = Sediaan::find($id);
		$nama = $sediaan->sediaan;
		if ($sediaan->delete()) {
			$pesan = Yoga::suksesFlash('Sediaan ' . $nama .  ' <strong>BERHASIL</strong> Dihapus');
		} else {
			$pesan = Yoga::gagalFlash('Sediaan ' . $nama . ' <strong>GAGAL</strong> Dihapus');
		}

		return redirect('sediaans')->withPesan($pesan);
	}
	
	
	
}
