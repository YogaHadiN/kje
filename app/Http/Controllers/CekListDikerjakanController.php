<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CekListDikerjakan;

class CekListDikerjakanController extends Controller
{
    public function byTanggal($tanggal){
        $cek_list_dikerjakans = CekListDikerjakan::where('created_at', 'like' , $tanggal . '%')->get();
        return view('cek_list_harians.byTanggal', compact(
            'cek_list_dikerjakans'
        ));
    }
}
