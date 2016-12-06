<?php

namespace App\Http\Controllers;

use Input;
use App\Http\Requests;
use App\AntrianPeriksa;
use App\Periksa;
use Endroid\QrCode\QrCode;

class RuangPeriksaController extends Controller
{

	public function index(){

		return redirect('ruangperiksa/umum');
	}
	public function umum(){

		$antrianperiksa = AntrianPeriksa::with('pasien', 'staf', 'asuransi')
			->where('poli', '=', 'umum')
			->orWhere('poli', 'luka')
			->orWhere('poli', 'sks')
			->orderBy('antrian', 'asc')
			->get();

		$postperiksa = Periksa::whereRaw("lewat_poli = 1 and lewat_kasir2 = 0 and ( poli='umum' or poli='sks' or poli='luka' )")->orderBy('tanggal')->orderBy('antrian')->get();
		return view('antrianperiksas.index')
			->withPostperiksa($postperiksa)
			->withAntrianperiksa($antrianperiksa)
			->withPoli('umum');
	}
	public function kandungan(){
		$poli = 'kandungan';
		$antrianperiksa = AntrianPeriksa::with('pasien', 'staf', 'asuransi')->where('poli', '=', $poli)->get();
		$postperiksa = Periksa::whereRaw("lewat_poli = 1 and lewat_kasir2 = 0 and ( poli='kandungan' or poli='KB 1 Bulan' or poli='KB 3 Bulan')")->orderBy('tanggal')->orderBy('antrian')->get();
		return view('antrianperiksas.index')
			->withPostperiksa($postperiksa)
			->withAntrianperiksa($antrianperiksa)
			->withPoli($poli);
	}
	public function suntikkb(){
		$antrianperiksa = AntrianPeriksa::with('pasien', 'staf', 'asuransi')->where('poli', 'like', 'kb %')->get();
		$postperiksa = Periksa::whereRaw("lewat_poli = 1 and lewat_kasir2 = 0 and poli='kandungan'")->orderBy('tanggal')->orderBy('antrian')->get();
		return view('antrianperiksas.index')
			->withPostperiksa($postperiksa)
			->withAntrianperiksa($antrianperiksa)
			->withPoli('Suntik KB');
	}
	public function anc(){
		$poli = 'anc';
		$antrianperiksa = AntrianPeriksa::with('pasien', 'staf', 'asuransi')->where('poli', '=', $poli)->get();
		$postperiksa = Periksa::whereRaw("lewat_poli = 1 and lewat_kasir2 = 0 and poli='{$poli}'")->orderBy('tanggal')->orderBy('antrian')->get();
		return view('antrianperiksas.index')
			->withPostperiksa($postperiksa)
			->withAntrianperiksa($antrianperiksa)
			->withPoli($poli);
	}
    public function usg(){
		$poli = 'usg';
		$antrianperiksa = AntrianPeriksa::with('pasien', 'staf', 'asuransi')->where('poli', '=', $poli)->get();
		$postperiksa = Periksa::whereRaw("lewat_poli = 1 and lewat_kasir2 = 0 and poli='{$poli}'")->orderBy('tanggal')->orderBy('antrian')->get();
		return view('antrianperiksas.index')
			->withPostperiksa($postperiksa)
			->withAntrianperiksa($antrianperiksa)
			->withPoli($poli);
	}
	public function usgabdomen(){
		$poli = 'usgabdomen';
		$antrianperiksa = AntrianPeriksa::with('pasien', 'staf', 'asuransi')->where('poli', '=', $poli)->get();
		$postperiksa = Periksa::whereRaw("lewat_poli = 1 and lewat_kasir2 = 0 and poli='{$poli}'")->orderBy('tanggal')->orderBy('antrian')->get();
		return view('antrianperiksas.index')
			->withPostperiksa($postperiksa)
			->withAntrianperiksa($antrianperiksa)
			->withPoli($poli);
	}
	public function gigi(){
		$poli = 'gigi';
		$antrianperiksa = AntrianPeriksa::with('pasien', 'staf', 'asuransi')->where('poli', '=', $poli)->get();
		$postperiksa = Periksa::whereRaw("lewat_poli = 1 and lewat_kasir2 = 0 and poli='gigi'")->orderBy('tanggal')->orderBy('antrian')->get();
		return view('antrianperiksas.index')
			->withPostperiksa($postperiksa)
			->withAntrianperiksa($antrianperiksa)
			->withPoli($poli);
	}
	public function darurat(){
		$poli = 'darurat';
		$antrianperiksa = AntrianPeriksa::with('pasien', 'staf', 'asuransi')->where('poli', '=', $poli)->orderBy('tanggal')->orderBy('antrian')->get();
		$postperiksa = Periksa::whereRaw("lewat_poli = 1 and lewat_kasir2 = 0 and poli='darurat'")->get();
		return view('antrianperiksas.index')
			->withPostperiksa($postperiksa)
			->withAntrianperiksa($antrianperiksa)
			->withPoli($poli);
	}
	public function estetika(){
		$poli = 'estetika';
		$antrianperiksa = AntrianPeriksa::with('pasien', 'staf', 'asuransi')->where('poli', '=', $poli)->orderBy('tanggal')->orderBy('antrian')->get();
		$postperiksa = Periksa::whereRaw("lewat_poli = 1 and lewat_kasir2 = 0 and poli='estetika'")->get();

		return view('antrianperiksas.index')
			->withPostperiksa($postperiksa)
			->withAntrianperiksa($antrianperiksa)
			->withPoli($poli);
	}
	

}

