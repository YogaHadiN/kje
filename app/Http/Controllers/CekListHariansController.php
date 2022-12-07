<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruangan;
use Input;
use App\Models\CekHarianAnafilaktikKit;

class CekListHariansController extends Controller
{
    public function index(){
        $ruangans = Ruangan::all();
        return view('cek_list_harians.index', compact('ruangans'));
    }
    public function show($ruangan_id){
        $ruangan                     = Ruangan::find($ruangan_id);
        $cek_harian_anafilaktik_kits = CekHarianAnafilaktikKit::where('ruangan_id', $ruangan_id)->get();
        return view('cek_list_harians.show', compact(
            'ruangan',
            'cek_harian_anafilaktik_kits'
        ));
    }
    public function create(){
       return view('cek_list_harians.create'); 
    }
    
    public function store(){
        $messages = [
            'required' => ':attribute Harus Diisi',
        ];
        $rules = [
            'no_telp' => 'required|numeric',
        ];

        $validator = \Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }



    }
    
}
