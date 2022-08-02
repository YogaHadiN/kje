<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporPajak;
use App\Models\JenisPajak;
use Input;
use App\Models\Classes\Yoga;
use DB;

class LaporPajakController extends Controller
{
    public function index(){
        $lapor_pajaks = LaporPajak::all();
        return view('lapor_pajaks.index', compact(
            'lapor_pajaks'
        ));
    }
    public function create(){
        return view('lapor_pajaks.create');
    }
    public function edit($id){
        $model_singular = LaporPajak::find($id);
        return view('lapor_pajaks.edit', compact('lapor_pajak'));
    }
    public function store(Request $request){
        dd( Input::all() );
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $model_singular = new LaporPajak;
        $model_singular = $this->processData($model_singular);

        $pesan = Yoga::suksesFlash('LaporPajak baru berhasil dibuat');
        return redirect('lapor_pajaks')->withPesan($pesan);
    }
    public function update($id, Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $model_singular = LaporPajak::find($id);
        $model_singular = $this->processData($model_singular);

        $pesan = Yoga::suksesFlash('LaporPajak berhasil diupdate');
        return redirect('lapor_pajaks')->withPesan($pesan);
    }
    public function destroy($id){
        LaporPajak::destroy($id);
        $pesan = Yoga::suksesFlash('LaporPajak berhasil dihapus');
        return redirect('lapor_pajaks')->withPesan($pesan);
    }

    public function processData($model_singular){
        dd( 'processData belum diatur' );
        $model_singular = $this->lapor_pajak;
        $model_singular->save();

        return $model_singular;
    }
    public function import(){
        return 'Not Yet Handled';
        $file      = Input::file('file');
        $file_name = $file->getClientOriginalName();
        $file->move('files', $file_name);
        $results   = Excel::load('files/' . $file_name, function($reader){
            $reader->all();
        })->get();
        $lapor_pajaks     = [];
        $timestamp = date('Y-m-d H:i:s');
        foreach ($results as $result) {
            $lapor_pajaks[] = [

                // Do insert here

							'tenant_id'  => session()->get('tenant_id'),
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];
        }
        LaporPajak::insert($lapor_pajaks);
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
    public function getPeriodePajak(){
        $jenis_pajak_id = Input::get('jenis_pajak_id');
        $jenis_pajak    = JenisPajak::find( $jenis_pajak_id );
        return $jenis_pajak->periode_id;
    }
}
