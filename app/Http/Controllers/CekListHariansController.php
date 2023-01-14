<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruangan;
use App\Http\Controllers\WablasController;
use Input;
use App\Models\CekHarianAnafilaktikKit;
use App\Models\CekListDikerjakan;
use App\Models\CekListRuangan;

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
        
        if ( $this->masihAdaYangBelumCekListHariIni() ) {
            
        }
        if ( $this->masihAdaYangBelumCekListHariIni() ) {
            $whatsapp_bot = new WhatsappBot;
            $this->processData($whatsapp_bot);
        }

        $pesan = Yoga::suksesFlash('Permintaan cek list sudah dikirim');
        return redirect()->back()->withPesan($pesan);
    }

    public function processData($whatsapp_bot){
        $whatsapp_bot->whatsapp_bot_service_id = 1;
        $whatsapp_bot->no_telp = Input::get('no_telp');
        $whatsapp_bot->save();

        $wa = WablasController;
        $wa->sendSingle( Input::get('no_telp'), 'silahkan mulai mengisi' );
    }
    public function masihAdaYangBelumCekListHariIni(){
        $cek_list_ruangan_harian_ids  = CekListRuangan::where('frekuensi_cek_id', 1)->pluck('id');
        $cek_list_dikerjakan_hari_ini = CekListDikerjakan::where('created_at', 'like', date('Y-m-d') . '%')
                                                        ->whereIn('cek_list_ruangan_id', $cek_list_ruangan_harian_ids)
                                                        ->groupBy('cek_list_ruangan_id')
                                                        ->get();
        return $cek_list_ruangan_harian_ids->count() == $cek_list_dikerjakan_hari_ini->count();
    }
    
}


