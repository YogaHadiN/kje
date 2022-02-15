<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AntrianKelengkapanDokumen;
use Input;
use App\Http\Controllers\CustomController;
use App\Models\Classes\Yoga;
use DB;

class AntrianKelengkapanDokumenController extends Controller
{
    public function index(){
        $antrian = AntrianKelengkapanDokumen::with('periksa.pasien', 'periksa.asuransi')->get();
        return view('antrian_kelengkapan_dokumens.index', compact(
            'antrian'
        ));
    }
    public function create(){
        return view('antrian_kelengkapan_dokumens.create');
    }
    public function show($id){
        $antrian_kelengkapan_dokumen = AntrianKelengkapanDokumen::find($id);
        $periksa                     = $antrian_kelengkapan_dokumen->periksa;

        $cc = new CustomController;
		$warna = $cc->warna;

        return view('antrian_kelengkapan_dokumens.show', compact(
            'periksa',
            'antrian_kelengkapan_dokumen',
            'warna'
        ));
    }
    public function edit($id){
        $antrian_kelengkapan_dokumen = AntrianKelengkapanDokumen::find($id);
        return view('antrian_kelengkapan_dokumens.edit', compact('antrian_kelengkapan_dokumen'));
    }
    public function proses(Request $request, $id){
        /* dd( 'yes' ); */
        AntrianKelengkapanDokumen::destroy($id);
        $pesan = Yoga::suksesFlash('Kelengkapan dokumen berhasil dilengkapi');
        return redirect('antrian_kelengkapan_dokumens')->withPesan($pesan);
    }
    public function update($id, Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $antrian_kelengkapan_dokumen = AntrianKelengkapanDokumen::find($id);
        $antrian_kelengkapan_dokumen = $this->processData($antrian_kelengkapan_dokumen);

        $pesan = Yoga::suksesFlash('AntrianKelengkapanDokumen berhasil diupdate');
        return redirect('antrian_kelengkapan_dokumens')->withPesan($pesan);
    }
    public function destroy($id){
        AntrianKelengkapanDokumen::destroy($id);
        $pesan = Yoga::suksesFlash('AntrianKelengkapanDokumen berhasil dihapus');
        return redirect('antrian_kelengkapan_dokumens')->withPesan($pesan);
    }

    public function processData($antrian_kelengkapan_dokumen){
        dd( 'processData belum diatur' );
        $antrian_kelengkapan_dokumen = $this->antrian_kelengkapan_dokumen;
        $antrian_kelengkapan_dokumen->save();

        return $antrian_kelengkapan_dokumen;
    }
    public function import(){
        return 'Not Yet Handled';
        $file      = Input::file('file');
        $file_name = $file->getClientOriginalName();
        $file->move('files', $file_name);
        $results   = Excel::load('files/' . $file_name, function($reader){
            $reader->all();
        })->get();
        $antrian_kelengkapan_dokumens     = [];
        $timestamp = date('Y-m-d H:i:s');
        foreach ($results as $result) {
            $antrian_kelengkapan_dokumens[] = [

                // Do insert here

                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];
        }
        AntrianKelengkapanDokumen::insert($antrian_kelengkapan_dokumens);
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
