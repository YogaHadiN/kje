<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\AntrianPeriksa;
use App\Periksa;

class RuangPeriksaController extends Controller
{


	public function umum(){

		$antrianperiksa = AntrianPeriksa::where('poli', '=', 'umum')
		->orWhere('poli', 'luka')
		->orWhere('poli', 'sks')
		->orderBy('antrian', 'asc')->get();
		$postperiksa = Periksa::whereRaw("lewat_poli = 1 and (lewat_kasir = 0 or lewat_kasir2 = 0) and poli='umum'")->get();
		return view('antrianperiksas.index')
			->withPostperiksa($postperiksa)
			->withAntrianperiksa($antrianperiksa)
			->withPoli('umum');
	}
	public function kandungan(){
		$poli = 'kandungan';
		$antrianperiksa = AntrianPeriksa::where('poli', '=', $poli)->get();
		$postperiksa = Periksa::whereRaw("lewat_poli = 1 and (lewat_kasir = 0 or lewat_kasir2 = 0) and poli='kandungan'")->get();
		return view('antrianperiksas.index')
			->withPostperiksa($postperiksa)
			->withAntrianperiksa($antrianperiksa)
			->withPoli($poli);
	}
	public function suntikkb(){
		$antrianperiksa = AntrianPeriksa::where('poli', 'like', 'kb %')->get();
		$postperiksa = Periksa::whereRaw("lewat_poli = 1 and (lewat_kasir = 0 or lewat_kasir2 = 0) and poli='kandungan'")->get();
		return view('antrianperiksas.index')
			->withPostperiksa($postperiksa)
			->withAntrianperiksa($antrianperiksa)
			->withPoli('Suntik KB');
	}
	public function anc(){
		$poli = 'anc';
		$antrianperiksa = AntrianPeriksa::where('poli', '=', $poli)->get();
		$postperiksa = Periksa::whereRaw("lewat_poli = 1 and (lewat_kasir = 0 or lewat_kasir2 = 0) and poli='{$poli}'")->get();
		return view('antrianperiksas.index')
			->withPostperiksa($postperiksa)
			->withAntrianperiksa($antrianperiksa)
			->withPoli($poli);
	}
	public function usg(){
		$poli = 'usg';
		$antrianperiksa = AntrianPeriksa::where('poli', '=', $poli)->get();
		$postperiksa = Periksa::whereRaw("lewat_poli = 1 and (lewat_kasir = 0 or lewat_kasir2 = 0) and poli='{$poli}'")->get();
		return view('antrianperiksas.index')
			->withPostperiksa($postperiksa)
			->withAntrianperiksa($antrianperiksa)
			->withPoli($poli);
	}
	public function usgabdomen(){
		$poli = 'usgabdomen';
		$antrianperiksa = AntrianPeriksa::where('poli', '=', $poli)->get();
		$postperiksa = Periksa::whereRaw("lewat_poli = 1 and (lewat_kasir = 0 or lewat_kasir2 = 0) and poli='{$poli}'")->get();
		return view('antrianperiksas.index')
			->withPostperiksa($postperiksa)
			->withAntrianperiksa($antrianperiksa)
			->withPoli($poli);
	}
	public function gigi(){
		$poli = 'gigi';
		$antrianperiksa = AntrianPeriksa::where('poli', '=', $poli)->get();
		$postperiksa = Periksa::whereRaw("lewat_poli = 1 and (lewat_kasir = 0 or lewat_kasir2 = 0) and poli='gigi'")->get();
		return view('antrianperiksas.index')
			->withPostperiksa($postperiksa)
			->withAntrianperiksa($antrianperiksa)
			->withPoli($poli);
	}
	public function darurat(){
		$poli = 'darurat';
		$antrianperiksa = AntrianPeriksa::where('poli', '=', $poli)->get();
		$postperiksa = Periksa::whereRaw("lewat_poli = 1 and (lewat_kasir = 0 or lewat_kasir2 = 0) and poli='darurat'")->get();
		return view('antrianperiksas.index')
			->withPostperiksa($postperiksa)
			->withAntrianperiksa($antrianperiksa)
			->withPoli($poli);
	}

}