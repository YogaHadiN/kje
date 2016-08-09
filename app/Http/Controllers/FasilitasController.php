<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Fasilitas;
use App\AntrianPeriksa;
use App\RumahSakit;

class FasilitasController extends Controller
{
    public function antrian_pasien(){
		$antrianperiksa = AntrianPeriksa::with('pasien')->orderBy('antrian')->take(10)->get(['pasien_id', 'antrian']);
		return view('fasilitas.antrian', compact('antrianperiksa'));
    }
    public function survey(){
		return view('surveys.survey');
    }
    
}
