<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruangan;
use App\Models\CekHarianAnafilaktikKit;

class CekListHariansController extends Controller
{
    public function index(){
        $ruangans = Ruangan::all();
        return view('cek_list_harians.index', compact('ruangans'));
    }
    public function show($ruangan_id){
        $ruangan = Ruangan::find($ruangan_id);
        $cek_harian_anafilaktik_kits = CekHarianAnafilaktikKit::where('ruangan_id', $ruangan_id)->get();
        return view('cek_list_harians.show', compact(
            'ruangan',
            'cek_harian_anafilaktik_kits'
        ));
    }
    
}
