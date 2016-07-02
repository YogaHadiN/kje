<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\FakturBeli;
use App\NotaJual;
use App\Classes\Yoga;
use App\Supplier;

class NotaJualsController extends Controller
{

    public function index(){
        $nota_juals = NotaJual::latest()->get();
        return view('nota_juals.index', compact('nota_juals'));
    }
    public function show($id){
         $nota_jual = NotaJual::find($id);
         return view('nota_juals.show', compact('nota_jual'));
    }
    
    
}
