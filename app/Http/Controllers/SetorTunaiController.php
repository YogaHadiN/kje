<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SetorTunai;
use App\Models\Coa;
use Input;
use Carbon\Carbon;
use App\Models\Classes\Yoga;
use DB;
class SetorTunaiController extends Controller
{
    public function index(){
        $setor_tunais = SetorTunai::all();
        return view('setor_tunais.index', compact(
            'setor_tunais'
        ));
    }
    public function create(){
        $tujuan_uang_list = Coa::whereRaw('kode_coa between 110000 and 110004')->pluck('coa', 'id');
        return view('setor_tunais.create', compact('tujuan_uang_list'));
    }
    public function edit($id){
        $setor_tunai = SetorTunai::find($id);
        $tujuan_uang_list = Coa::whereRaw('kode_coa between 110000 and 110004')->pluck('coa', 'id');
        return view('setor_tunais.edit', compact('setor_tunai', 'tujuan_uang_list'));
    }
    public function store(Request $request){
        DB::beginTransaction();
        try {
            
            if ($this->valid( Input::all() )) {
                return $this->valid( Input::all() );
            }
            $setor_tunai = new SetorTunai;
            $setor_tunai = $this->processData($setor_tunai);

            $pesan = Yoga::suksesFlash('SetorTunai baru berhasil dibuat');
            DB::commit();
            return redirect('setor_tunais')->withPesan($pesan);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
    public function update($id, Request $request){

        DB::beginTransaction();
        try {
            if ($this->valid( Input::all(), true )) {
                return $this->valid( Input::all(), true );
            }
            $setor_tunai = SetorTunai::find($id);
            $setor_tunai = $this->processData($setor_tunai);

            $pesan = Yoga::suksesFlash('SetorTunai berhasil diupdate');

            DB::commit();
            return redirect('setor_tunais')->withPesan($pesan);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
    public function destroy($id){
        $setor_tunai = SetorTunai::find($id);

        $setor_tunai->jurnals()->delete();
        $setor_tunai->delete();

        $pesan = Yoga::suksesFlash('SetorTunai berhasil dihapus');
        return redirect('setor_tunais')->withPesan($pesan);
    }

    public function processData($setor_tunai){
        $setor_tunai->tanggal    = Carbon::createFromFormat('d-m-Y', Input::get('tanggal'))->format('Y-m-d');
        $setor_tunai->staf_id    = Input::get("staf_id");
        $setor_tunai->coa_id     = Input::get("coa_id");
        $setor_tunai->nominal    = Yoga::clean(Input::get("nominal"));
        $setor_tunai->save();

        if ( Input::hasFile('nota_image')) {
            $setor_tunai->nota_image = uploadFile('setor', 'nota_image', $setor_tunai->id, 'img/setor_tunai');
            $setor_tunai->save();
        }


        $jurnal_created_at = $setor_tunai->jurnals()->first()->created_at;

        $jurnal_umums[] = [
            'coa_id'     => Input::get('coa_id'), // Tujuan transfer
            'debit'      => 1,
            'nilai'      => $setor_tunai->nominal,
            'created_at' => $jurnal_created_at
        ];

        $coa_110000 = Coa::kasDiTangan();

        $jurnal_umums[] = [
            'coa_id'     => $coa_110000->id, // Kas di tangan
            'debit'      => 0,
            'nilai'      => $setor_tunai->nominal,
            'created_at' => $jurnal_created_at
        ];

        $setor_tunai->jurnals()->delete();
        $setor_tunai->jurnals()->createMany($jurnal_umums);

        return $setor_tunai;
    }
    public function import(){
        return 'Not Yet Handled';
        $file      = Input::file('file');
        $file_name = $file->getClientOriginalName();
        $file->move('files', $file_name);
        $results   = Excel::load('files/' . $file_name, function($reader){
            $reader->all();
        })->get();
        $setor_tunais     = [];
        $timestamp = date('Y-m-d H:i:s');
        foreach ($results as $result) {
            $setor_tunais[] = [

                // Do insert here

                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];
        }
        SetorTunai::insert($setor_tunais);
        $pesan = Yoga::suksesFlash('Import Data Berhasil');
        return redirect()->back()->withPesan($pesan);
    }
    private function valid( $data, $edit = false ){
        $messages = [
            'required' => ':attribute Harus Diisi',
        ];
        $rules = [
            'tanggal'    => 'required|date_format:d-m-Y|before:tomorrow',
            'staf_id'    => 'required',
            'coa_id'     => 'required',
            'nominal'    => 'required',
        ];

        if ($edit) {
            $rules['nota_image'] = 'nullable|max:2048';
        } else {
            $rules['nota_image'] = 'required|max:2048';
        }

        $validator = \Validator::make($data, $rules, $messages);
        
        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }
    }
}
