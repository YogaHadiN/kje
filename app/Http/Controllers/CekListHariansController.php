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
        $whatsapp_bot->no_telp =  '62' . substr(Input::get('no_telp'), 1) ;
        $whatsapp_bot->save();

        $wa = WablasController;
        $cek = $this->cekListBelumDilakukan();
        $message = "Silahkan mulai cek " . $cek->cekList->cek_list . " di ruangan " . $cek->ruangan->ruangan;
        $wa->sendSingle( $whatsapp_bot->no_telp, $message);
    }
    public function masihAdaYangBelumCekListHariIni(){
        $cek_list_ruangan_harian_ids  = CekListRuangan::where('frekuensi_cek_id', 1)->pluck('id');
        $cek_list_dikerjakan_hari_ini = CekListDikerjakan::where('created_at', 'like', date('Y-m-d') . '%')
                                                        ->whereIn('cek_list_ruangan_id', $cek_list_ruangan_harian_ids)
                                                        ->groupBy('cek_list_ruangan_id')
                                                        ->get();
        return $cek_list_ruangan_harian_ids->count() == $cek_list_dikerjakan_hari_ini->count();
    }
    public function cekListBelumDilakukan(){
        $cek_list_ruangan_harians = CekListRuangan::with('cekList', 'ruangan')
                                    ->where('frekuensi_cek_id', 1)
                                    ->orderBy('ruangan_id', 'asc')
                                    ->orderBy('cek_list_id', 'asc')
                                    ->get();
        $cek_list_ruangan_ids = [];
        foreach ($cek_list_ruangan_harians as $cek) {
            $cek_list_ruangan_ids[] = $cek->id;
        }
        $cek_list_harians_dikerjakans = CekListDikerjakan::whereIn('cek_list_ruangan_id', $cek_list_ruangan_ids)
                                                        ->where('created_at', 'like', date('Y-m-d') . '%')
                                                        ->groupBy('cek_list_ruangan_id')
                                                        ->get();
        if ( $cek_list_ruangan_harians->count() !== $cek_list_harians_dikerjakans->count() {

            WhatsappBot::where('no_telp', $this->no_telp)
                ->where('whatsapp_bot_service_id',1)
                ->update([
                'whatsapp_bot_service_id' => 2
            ]);

            foreach ($cek_list_ruangan_harians as $cek) {
                $cek_list_dikerjakan = $this->cekListDikerjakanUntukCekListRuanganIni( $cek->id );
                if ( 
                    is_null(  $cek_list_dikerjakan  )
                ) {
                    return $cek;
                    break;
                }
            }
        }
    }
    
}


