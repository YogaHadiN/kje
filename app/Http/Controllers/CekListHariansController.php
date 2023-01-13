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
        $ruangan = Ruangan::with(
            'cekListRuangan',
        )
        ->where('id', $ruangan_id)->first();
        return view('cek_list_harians.show', compact(
            'ruangan',
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
        $whatsapp_cek_list_harian = new WhatsappCekListHarian;
        $this->processData($whatsapp_cek_list_harian);

        $pesan = Yoga::suksesFlash('Permintaan cek list sudah dikirim');
        return redirect()->back()->withPesan($pesan);
    }

    public function processData($whatsapp_cek_list_harian){
        $whatsapp_cek_list_harian->staf_id = Input::get('staf_id');
        $whatsapp_cek_list_harian->no_telp = Input::get('no_telp');
        $whatsapp_cek_list_harian->save();

        $whatsapp_cek_list_harian->whatsappbot()->create([
            'no_telp' => Input::get('no_telp');
        ]);
    }
}





