<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CekListRuangan;
use App\Models\Ruangan;
use Input;
use App\Models\Classes\Yoga;
use DB;
class CekListRuanganController extends Controller
{
    public function index($id){
        $cek_list_ruangans = CekListRuangan::where('ruangan_id', $id)->get();
        /* dd( $cek_list_ruangans ); */
        $ruangan           = Ruangan::find( $id );
        return view('cek_list_ruangans.index', compact(
            'ruangan',
            'cek_list_ruangans'
        ));
    }
    public function create($id){
        $ruangan           = Ruangan::find( $id );
        return view('cek_list_ruangans.create', compact('ruangan'));
    }
    public function edit($id){
        $cek_list_ruangan = CekListRuangan::find($id);
        $ruangan = $cek_list_ruangan->ruangan;
        return view('cek_list_ruangans.edit', compact(
            'cek_list_ruangan',
            'ruangan'
        ));
    }
    public function store(Request $request, $id){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $cek_list_ruangan = new CekListRuangan;
        $cek_list_ruangan = $this->processData($cek_list_ruangan, $id);

        $pesan = Yoga::suksesFlash('CekListRuangan baru berhasil dibuat');
        return redirect('cek_list_ruangans/' . $id)->withPesan($pesan);
    }
    public function update($id, Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $cek_list_ruangan = CekListRuangan::find($id);
        $cek_list_ruangan = $this->processData($cek_list_ruangan, $id);

        $pesan = Yoga::suksesFlash('CekListRuangan berhasil diupdate');
        return redirect('cek_list_ruangans/' . $cek_list_ruangan->ruangan_id)->withPesan($pesan);
    }
    public function destroy($id){

        $cek_list_ruangan = CekListRuangan::find($id);
        $ruangan_id = $cek_list_ruangan->ruangan_id;
        $cek_list_ruangan->delete();
        $pesan = Yoga::suksesFlash('CekListRuangan berhasil dihapus');
        return redirect('cek_list_ruangans/' . $ruangan_id)->withPesan($pesan);
    }

    public function processData($cek_list_ruangan, $ruangan_id){
        $cek_list_ruangan->ruangan_id       = $ruangan_id;
        $cek_list_ruangan->cek_list_id      = Input::get('cek_list_id');
        $cek_list_ruangan->frekuensi_cek_id = Input::get('frekuensi_cek_id');
        $cek_list_ruangan->limit_id         = Input::get('limit_id');
        $cek_list_ruangan->jumlah_normal    = Input::get('jumlah_normal');
        $cek_list_ruangan->save();

        return $cek_list_ruangan;
    }
    public function import(){
        return 'Not Yet Handled';
        $file      = Input::file('file');
        $file_name = $file->getClientOriginalName();
        $file->move('files', $file_name);
        $results   = Excel::load('files/' . $file_name, function($reader){
            $reader->all();
        })->get();
        $cek_list_ruangans     = [];
        $timestamp = date('Y-m-d H:i:s');
        foreach ($results as $result) {
            $cek_list_ruangans[] = [

                // Do insert here

                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];
        }
        CekListRuangan::insert($cek_list_ruangans);
        $pesan = Yoga::suksesFlash('Import Data Berhasil');
        return redirect()->back()->withPesan($pesan);
    }
    private function valid( $data ){
        $messages = [
            'required' => ':attribute Harus Diisi',
        ];
        $rules = [
              "cek_list_id"      => "required|numeric",
              "frekuensi_cek_id" => "required|numeric",
              "limit_id"         => "required|numeric",
              "jumlah_normal"    => "required|numeric",
        ];
        $validator = \Validator::make($data, $rules, $messages);
        
        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }
    }

}
