<?php

namespace App\Http\Controllers;

use Input;
use App\Http\Requests;
use App\Models\Asuransi;
use App\Models\Tarif;
use App\Models\BayarDokter;
use App\Models\Classes\Yoga;

class BayarDoktersController extends Controller
{
    public function index(){
        $bayardokters = BayarDokter::latest()->paginate(15);
        return view('bayar_dokters.index', compact('bayardokters'));
    }
        
    //
}
