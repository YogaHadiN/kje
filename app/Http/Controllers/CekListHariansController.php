<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CekListHariansController extends Controller
{
    public function index(){
        return view('cek_list_harians.index');
    }
}
