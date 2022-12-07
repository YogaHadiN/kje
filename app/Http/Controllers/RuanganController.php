<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruangan;
use Input;
use App\Models\Classes\Yoga;
use DB;
class RuanganController extends Controller
{
    public function index(){
        $ruangans = Ruangan::all();
        return view('ruangans.index', compact(
            'ruangans'
        ));
    }
    public function create(){
        return view('ruangans.create');
    }
    public function edit($id){
        $ruangan = Ruangan::find($id);
        return view('ruangans.edit', compact('ruangan'));
    }
    public function store(Request $request){
        dd( Input::all() );
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $ruangan = new Ruangan;
        $ruangan = $this->processData($ruangan);

        $pesan = Yoga::suksesFlash('Ruangan baru berhasil dibuat');
        return redirect('ruangans')->withPesan($pesan);
    }
    public function update($id, Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $ruangan = Ruangan::find($id);
        $ruangan = $this->processData($ruangan);

        $pesan = Yoga::suksesFlash('Ruangan berhasil diupdate');
        return redirect('ruangans')->withPesan($pesan);
    }
    public function destroy($id){
        Ruangan::destroy($id);
        $pesan = Yoga::suksesFlash('Ruangan berhasil dihapus');
        return redirect('ruangans')->withPesan($pesan);
    }

    public function processData($ruangan){
        dd( 'processData belum diatur' );
        $ruangan = $this->ruangan;
        $ruangan->save();

        return $ruangan;
    }
    public function import(){
        return 'Not Yet Handled';
        $file      = Input::file('file');
        $file_name = $file->getClientOriginalName();
        $file->move('files', $file_name);
        $results   = Excel::load('files/' . $file_name, function($reader){
            $reader->all();
        })->get();
        $ruangans     = [];
        $timestamp = date('Y-m-d H:i:s');
        foreach ($results as $result) {
            $ruangans[] = [

                // Do insert here

                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];
        }
        Ruangan::insert($ruangans);
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
    public function aturCekList($id){
        
    }
    
    
}
