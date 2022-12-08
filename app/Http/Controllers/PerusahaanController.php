<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perusahaan;
use Input;
use App\Models\Classes\Yoga;
use DB;
class PerusahaanController extends Controller
{
    public function index(){
        $perusahaans = Perusahaan::all();
        return view('perusahaans.index', compact(
            'perusahaans'
        ));
    }
    public function create(){
        return view('perusahaans.create');
    }
    public function edit($id){
        $perusahaan = Perusahaan::with('peserta')->where('id',$id)->first();
        return view('perusahaans.edit', compact('perusahaan'));
    }
    public function store(Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $perusahaan = new Perusahaan;
        $perusahaan = $this->processData($perusahaan);

        $pesan = Yoga::suksesFlash('Perusahaan baru berhasil dibuat');
        return redirect('perusahaans')->withPesan($pesan);
    }
    public function update($id, Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $perusahaan = Perusahaan::find($id);
        $perusahaan = $this->processData($perusahaan);

        $pesan = Yoga::suksesFlash('Perusahaan berhasil diupdate');
        return redirect('perusahaans')->withPesan($pesan);
    }
    public function destroy($id){
        Perusahaan::destroy($id);
        $pesan = Yoga::suksesFlash('Perusahaan berhasil dihapus');
        return redirect('perusahaans')->withPesan($pesan);
    }

    public function processData($perusahaan){
        $perusahaan->nama     = Input::get('nama');
        $perusahaan->no_telp  = Input::get('no_telp');
        $perusahaan->alamat   = Input::get('alamat');
        $perusahaan->nama_pic = Input::get('nama_pic');
        $perusahaan->save();

        return $perusahaan;
    }
    public function import(){
        return 'Not Yet Handled';
        $file      = Input::file('file');
        $file_name = $file->getClientOriginalName();
        $file->move('files', $file_name);
        $results   = Excel::load('files/' . $file_name, function($reader){
            $reader->all();
        })->get();
        $perusahaans     = [];
        $timestamp = date('Y-m-d H:i:s');
        foreach ($results as $result) {
            $perusahaans[] = [

                // Do insert here

                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];
        }
        Perusahaan::insert($perusahaans);
        $pesan = Yoga::suksesFlash('Import Data Berhasil');
        return redirect()->back()->withPesan($pesan);
    }
    private function valid( $data ){
        $messages = [
            'required' => ':attribute Harus Diisi',
        ];
        $rules = [
            'nama'     => 'required',
            'no_telp'  => 'required',
            'alamat'   => 'required',
            'nama_pic' => 'required',
        ];
        $validator = \Validator::make($data, $rules, $messages);
        
        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }
    }
}
