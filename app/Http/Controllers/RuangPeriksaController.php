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

		$postperiksa = Periksa::whereRaw("lewat_poli = 1 and lewat_kasir2 = 0 and ( poli='umum' or poli='sks' or poli='luka' )")->orderBy('tanggal')->orderBy('antrian')->get();
		return view('antrianperiksas.index')
			->withPostperiksa($postperiksa)
			->withAntrianperiksa($antrianperiksa)
			->withPoli('umum');
	}
	public function kandungan(){
		$poli = 'kandungan';
		$antrianperiksa = AntrianPeriksa::where('poli', '=', $poli)->get();
		$postperiksa = Periksa::whereRaw("lewat_poli = 1 and lewat_kasir2 = 0 and ( poli='kandungan' or poli='KB 1 Bulan' or poli='KB 3 Bulan')")->orderBy('tanggal')->orderBy('antrian')->get();
		return view('antrianperiksas.index')
			->withPostperiksa($postperiksa)
			->withAntrianperiksa($antrianperiksa)
			->withPoli($poli);
	}
	public function suntikkb(){
		$antrianperiksa = AntrianPeriksa::where('poli', 'like', 'kb %')->get();
		$postperiksa = Periksa::whereRaw("lewat_poli = 1 and lewat_kasir2 = 0 and poli='kandungan'")->orderBy('tanggal')->orderBy('antrian')->get();
		return view('antrianperiksas.index')
			->withPostperiksa($postperiksa)
			->withAntrianperiksa($antrianperiksa)
			->withPoli('Suntik KB');
	}
	public function anc(){
		$poli = 'anc';
		$antrianperiksa = AntrianPeriksa::where('poli', '=', $poli)->get();
		$postperiksa = Periksa::whereRaw("lewat_poli = 1 and lewat_kasir2 = 0 and poli='{$poli}'")->orderBy('tanggal')->orderBy('antrian')->get();
		return view('antrianperiksas.index')
			->withPostperiksa($postperiksa)
			->withAntrianperiksa($antrianperiksa)
			->withPoli($poli);
	}
    public function usg(){
		$poli = 'usg';
		$antrianperiksa = AntrianPeriksa::where('poli', '=', $poli)->get();
		$postperiksa = Periksa::whereRaw("lewat_poli = 1 and lewat_kasir2 = 0 and poli='{$poli}'")->orderBy('tanggal')->orderBy('antrian')->get();
		return view('antrianperiksas.index')
			->withPostperiksa($postperiksa)
			->withAntrianperiksa($antrianperiksa)
			->withPoli($poli);
	}
	public function usgabdomen(){
		$poli = 'usgabdomen';
		$antrianperiksa = AntrianPeriksa::where('poli', '=', $poli)->get();
		$postperiksa = Periksa::whereRaw("lewat_poli = 1 and lewat_kasir2 = 0 and poli='{$poli}'")->orderBy('tanggal')->orderBy('antrian')->get();
		return view('antrianperiksas.index')
			->withPostperiksa($postperiksa)
			->withAntrianperiksa($antrianperiksa)
			->withPoli($poli);
	}
	public function gigi(){
		$poli = 'gigi';
		$antrianperiksa = AntrianPeriksa::where('poli', '=', $poli)->get();
		$postperiksa = Periksa::whereRaw("lewat_poli = 1 and lewat_kasir2 = 0 and poli='gigi'")->orderBy('tanggal')->orderBy('antrian')->get();
		return view('antrianperiksas.index')
			->withPostperiksa($postperiksa)
			->withAntrianperiksa($antrianperiksa)
			->withPoli($poli);
	}
	public function darurat(){
		$poli = 'darurat';
		$antrianperiksa = AntrianPeriksa::where('poli', '=', $poli)->orderBy('tanggal')->orderBy('antrian')->get();
		$postperiksa = Periksa::whereRaw("lewat_poli = 1 and lewat_kasir2 = 0 and poli='darurat'")->get();
		return view('antrianperiksas.index')
			->withPostperiksa($postperiksa)
			->withAntrianperiksa($antrianperiksa)
			->withPoli($poli);
	}

}
