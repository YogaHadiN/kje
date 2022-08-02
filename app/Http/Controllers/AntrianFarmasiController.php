<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AntrianFarmasi;
use App\Models\AntrianKelengkapanDokumen;
use Input;
use Auth;
use App\Models\Classes\Yoga;
use App\Http\Controllers\AntrianPolisController;
use DB;

class AntrianFarmasiController extends Controller
{
    public function index(){

        $antrianfarmasis = AntrianFarmasi::with(
            'periksa.pasien', 
            'periksa.asuransi', 
            'antrian.jenis_antrian'
        )->get();

        return view('antrianfarmasis.index', compact(
            'antrianfarmasis'
        ));
    }
    public function create(){
        return view('antrianfarmasis.create');
    }
    public function edit($id){
        $antrianfarmasi = AntrianFarmasi::find($id);
        return view('antrianfarmasis.edit', compact('antrianfarmasi'));
    }
    public function store(Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $antrianfarmasi = new AntrianFarmasi;
        $antrianfarmasi = $this->processData($antrianfarmasi);

        $pesan = Yoga::suksesFlash('AntrianFarmasi baru berhasil dibuat');
        return redirect('antrianfarmasis')->withPesan($pesan);
    }

    public function show($id, Request $request){
        $antrianfarmasi = AntrianFarmasi::with('periksa.pasien')->where('id', $id)->first();

        $user = Auth::user();
        $user->surveyable_id = $id;
        $user->surveyable_type = 'App\Models\AntrianFarmasi';
        $user->save();

        return view('antrianfarmasis.show', compact(
            'antrianfarmasi'
        ));
    }
    public function proses($id, Request $request){
        $antrianfarmasi        = AntrianFarmasi::with('periksa.pasien', 'periksa.asuransi')->where('id', $id)->first();
        $nama_pasien           = $antrianfarmasi->periksa->pasien->nama;
        $pasien_id             = $antrianfarmasi->periksa->pasien_id;

        $user                  = Auth::user();
        $user->surveyable_type = null;
        $user->surveyable_id   = null;
        $user->save();

        $antrian                 = $antrianfarmasi->antrian;
        if (!is_null($antrian)) {
            $antrian->antriable_type = 'App\Models\Periksa';
            $antrian->antriable_id   = $antrianfarmasi->periksa->id;
            $antrian->save();
        }

        if ( $antrianfarmasi->periksa->butuh_kelengkapan_dokumen ) {
            $kelengkapan             = new AntrianKelengkapanDokumen;
            $kelengkapan->periksa_id = $antrianfarmasi->periksa_id;
            $kelengkapan->jam        = date('H:i:s');
            $kelengkapan->tanggal    = date('Y-m-d');
            $kelengkapan->save();
        }

        $antrianfarmasi->delete();

        $apc                   = new AntrianPolisController;
        $apc->updateJumlahAntrian(false, null);

        $pesan = Yoga::suksesFlash('Pasien <strong>'. $pasien_id . '-' . $nama_pasien . '</strong> BERHASIL diselesaikan dari farmasi');
        return redirect('antrianfarmasis')->withPesan($pesan);

    }
    public function update($id, Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $antrianfarmasi = AntrianFarmasi::find($id);
        $antrianfarmasi = $this->processData($antrianfarmasi);

        $pesan = Yoga::suksesFlash('AntrianFarmasi berhasil diupdate');
        return redirect('antrianfarmasis')->withPesan($pesan);
    }
    public function destroy($id){
        $antrianfarmasi = AntrianFarmasi::with('periksa')->where('id', $id )->first();
        $nama           = $antrianfarmasi->periksa->pasien_id . '-' . $antrianfarmasi->periksa->pasien->nama;
        $antrianfarmasi->delete();

        $antrian = $antrianfarmasi->antrian;
        if (!is_null($antrian)) {
            $antrian->antriable_type = 'App\Models\Periksa';
            $antrian->antriable_id = $antrianfarmasi->periksa_id;
            $antrian->save();
        }

        $pesan = Yoga::suksesFlash('Pasien <strong>' . $nama . '</strong> berhasil diselesaikan');
        return redirect('antrianfarmasis')->withPesan($pesan);
    }

    public function processData($antrianfarmasi){
        dd( 'processData belum diatur' );
        $antrianfarmasi = $this->antrianfarmasi;
        $antrianfarmasi->save();

        return $antrianfarmasi;
    }
    public function import(){
        return 'Not Yet Handled';
        $file      = Input::file('file');
        $file_name = $file->getClientOriginalName();
        $file->move('files', $file_name);
        $results   = Excel::load('files/' . $file_name, function($reader){
            $reader->all();
        })->get();
        $antrianfarmasis     = [];
        $timestamp = date('Y-m-d H:i:s');
        foreach ($results as $result) {
            $antrianfarmasis[] = [

                // Do insert here

							'tenant_id'  => session()->get('tenant_id'),
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];
        }
        AntrianFarmasi::insert($antrianfarmasis);
        $pesan = Yoga::suksesFlash('Import Data Berhasil');
        return redirect()->back()->withPesan($pesan);
    }
    private function valid( $data ){
        dd( 'validasi belum diatur' );
        $messages = [
            'required' => ':attribute Harus Diisi',
        ];
        $rules = [
            'data'           => 'required',
        ];
        $validator = \Validator::make($data, $rules, $messages);
        
        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }
    }
}
