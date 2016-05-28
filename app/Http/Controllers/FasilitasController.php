<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Fasilitas;
use App\RumahSakit;

class FasilitasController extends Controller
{
    public function destroy(){

        $tujuan_rujuk_id = Input::get('id');
        $rumah_sakit_id = Input::get('rumah_sakit_id');
        Fasilitas::where('tujuan_rujuk_id', $tujuan_rujuk_id)->where('rumah_sakit_id', $rumah_sakit_id)->delete();
        $data = RumahSakit::find($rumah_sakit_id)->tujuanRujuk;
        return json_encode($data);
    }
    public function update(){
        $tujuan_rujuk_id = Input::get('tujuan_rujuk_id');
        $rumah_sakit_id = Input::get('rumah_sakit_id');
        $fasiitas = Fasilitas::where('tujuan_rujuk_id', $tujuan_rujuk_id)->where('rumah_sakit_id', $rumah_sakit_id)->first();
        $fasilitas->rumah_sakit_id = Input::get('rumah_sakit_id');
        $fasilitas->tujuan_rujuk_id = Input::get('tujuan_rujuk_id');
        $fasilitas->save();

        
        $data = RumahSakit::find($rumah_sakit_id)->tujuanRujuk;
        return json_encode('data');

    }
    
}
