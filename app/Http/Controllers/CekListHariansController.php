<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Input;
use App\Models\CekObat;
use App\Models\Sms;
use App\Models\Classes\Yoga;
use App\Models\Merek;
use App\Models\CekPulsa;
use App\Models\CekListrik;

class CekListHariansController extends Controller
{

	public function obat(){
		
		$cek_obats = CekObat::with('rak', 'staf')->latest()->get();
		return view('cekListHarian.obat', compact('cek_obats'));
	}

	public function pulsa(){
		$cek_pulsas = CekPulsa::with('staf')->latest()->get();
		return view('cekListHarian.pulsa', compact('cek_pulsas'));
	}

	public function listrik(){
		$cek_listriks = CekListrik::with('staf')->latest()->get();
		return view('cekListHarian.listrik', compact('cek_listriks'));
	}

	public function pulsaPost(){
		$messages          = array(
			'required'    => ':attribute harus diisi terlebih dahulu',
		);
		$rules           = [
			'staf_id'         => 'required',
			'pulsa_zenziva'   => 'required',
			'expired_zenziva' => 'required',
			'expired_gammu'   => 'required',
			'pulsa_gammu'     => 'required'
		];
		
		$validator = \Validator::make(Input::all(), $rules, $messages);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		$cp                  = new CekPulsa;
		$cp->staf_id         = Input::get('staf_id');
		$cp->pulsa_zenziva   = Input::get('pulsa_zenziva');
		$cp->expired_zenziva = Yoga::datePrep( Input::get('expired_zenziva') );
		$cp->expired_gammu   = Yoga::datePrep( Input::get('expired_gammu') );
		$cp->pulsa_gammu     = Yoga::clean( Input::get('pulsa_gammu') );
		$cp->save();


		$pesan = Yoga::suksesFlash( "Berhasil melakukan cek pulsa");
		return redirect()->back()->withPesan($pesan);
	}
	public function obatPost(){
		$messages          = array(
			'required'    => ':attribute harus diisi terlebih dahulu',
		);
		$rules           = [
			'merek'   => 'required',
			'staf_id'   => 'required',
			'jumlah'   => 'required'
		];
		
		$validator = \Validator::make(Input::all(), $rules, $messages);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		$merek = Merek::find( Input::get('merek') );
		$rak = $merek->rak;

		$co                   = new CekObat;
		$co->rak_id           = $rak->id;
		$co->staf_id          = Input::get('staf_id');
		$co->jumlah_di_sistem = $rak->stok;
		$co->jumlah_di_hitung = Input::get('jumlah');
		$co->save();

		if ( $co->jumlah_di_sistem != $co->jumlah_di_hitung ) {
			if ( $co->jumlah_di_sistem > $co->jumlah_di_hitung ) {
				$pesan_sms = "Kehilangan ";
			} else {
				$pesan_sms = "Kelebihan ";
			}
			$pesan_sms .= "stok " . abs( $co->jumlah_di_sistem - $co->jumlah_di_hitung ) . " pcs merek " . $merek->merek  . ' Dihitung ' . $co->jumlah_di_hitung . ' pcs, dikomputer ' . $co->jumlah_di_sistem . ' pcs';
			Sms::send('081381912803', $pesan_sms);
		}

		$pesan = Yoga::suksesFlash('Cek Obat berhasil dengan rak <strong>' . $rak->id. '</strong> dilakukan jumlah yang dihitung sebesar <strong>' . Input::get('jumlah') . '</strong>');
		return redirect()->back()->withPesan($pesan);
	}

	public function listrikPost(){
		$messages          = array(
			'required'    => ':attribute harus diisi terlebih dahulu',
		);
		$rules           = [
			'staf_id'   => 'required',
			'listrik_A6'   => 'required',
			'listrik_A7'   => 'required',
			'listrik_A8'   => 'required'
		];
		
		$validator = \Validator::make(Input::all(), $rules, $messages);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}


		$cl = new CekListrik;
		$cl->staf_id	= Input::get('staf_id');
		$cl->listrik_A6	= Input::get('listrik_A6');
		$cl->listrik_A7	= Input::get('listrik_A7');
		$cl->listrik_A8	= Input::get('listrik_A8');
		$cl->save();


		$pesan = Yoga::suksesFlash("Cek Listrik berhasil");
		return redirect()->back()->withPesan($pesan);
	}


}
