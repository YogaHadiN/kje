<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FollowupTransaksi;
use Input;
use App\Models\Classes\Yoga;
use DB;

class FollowupTransaksiController extends Controller
{
    public function index(){
        $followup_transaksis = FollowupTransaksi::all();
        return view('followup_transaksis.index', compact(
            'followup_transaksis'
        ));
    }
    public function create(){
        return view('followup_transaksis.create');
    }
    public function edit($id){
        $followup_transaksi = FollowupTransaksi::find($id);
        return view('followup_transaksis.edit', compact('followup_transaksi'));
    }
    public function store(Request $request){
        dd( Input::all() );
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $followup_transaksi = new FollowupTransaksi;
        $followup_transaksi = $this->processData($followup_transaksi);

        $pesan = Yoga::suksesFlash('FollowupTransaksi baru berhasil dibuat');
        return redirect('followup_transaksis')->withPesan($pesan);
    }
    public function update($id, Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $followup_transaksi = FollowupTransaksi::find($id);
        $followup_transaksi = $this->processData($followup_transaksi);

        $pesan = Yoga::suksesFlash('FollowupTransaksi berhasil diupdate');
        return redirect('followup_transaksis')->withPesan($pesan);
    }
    public function destroy($id){
        FollowupTransaksi::destroy($id);
        $pesan = Yoga::suksesFlash('FollowupTransaksi berhasil dihapus');
        return redirect('followup_transaksis')->withPesan($pesan);
    }

    public function processData($followup_transaksi){
        dd( 'processData belum diatur' );
        $followup_transaksi = $this->followup_transaksi;
        $followup_transaksi->save();

        return $followup_transaksi;
    }
    public function import(){
        return 'Not Yet Handled';
        $file      = Input::file('file');
        $file_name = $file->getClientOriginalName();
        $file->move('files', $file_name);
        $results   = Excel::load('files/' . $file_name, function($reader){
            $reader->all();
        })->get();
        $followup_transaksis     = [];
        $timestamp = date('Y-m-d H:i:s');
        foreach ($results as $result) {
            $followup_transaksis[] = [

                // Do insert here

                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];
        }
        FollowupTransaksi::insert($followup_transaksis);
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
