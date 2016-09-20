<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Pasien;
use App\Classes\Yoga;

class RanapsController extends Controller
{
	public function index(){
		$ps = new Pasien;
		$statusPernikahan = $ps->statusPernikahan();
		$panggilan = $ps->panggilan();
		$asuransi = Yoga::asuransiList();
		$jenis_peserta = $ps->jenisPeserta();
		$staf = Yoga::stafList();
		$poli = Yoga::poliList();
		return view('ranaps.index')
			->withAsuransi($asuransi)
			->with('statusPernikahan', $statusPernikahan)
			->with('panggilan', $panggilan)
			->withJenis_peserta($jenis_peserta)
			->withStaf($staf)
			->withPoli($poli);
	}
	
}
