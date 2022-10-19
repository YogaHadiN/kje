<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FollowupTunggakan;
use Input;
use App\Models\Classes\Yoga;
use DB;

class FollowupTunggakanController extends Controller
{
    public function index(){
        $followup_tunggakans = FollowupTunggakan::all();
        return view('followup_tunggakans.index', compact(
            'followup_tunggakans'
        ));
    }
    public function create(){
        return view('followup_tunggakans.create');
    }
    public function edit($id){
        $followup_tunggakan = FollowupTunggakan::find($id);
        return view('followup_tunggakans.edit', compact('followup_tunggakan'));
    }
    public function store(Request $request){
        $rules['bukti_followup'] = 'required|image|mimes:jpeg,jpg,png,gif';
        if ($this->valid(Input::all(),$rules )) {
            return $this->valid( Input::all() );
        }
        $followup_tunggakan = new FollowupTunggakan;
        $followup_tunggakan = $this->processData($followup_tunggakan);

        $pesan = Yoga::suksesFlash('FollowupTunggakan baru berhasil dibuat');
        return redirect('followup_tunggakans')->withPesan($pesan);
    }
    public function update($id, Request $request){
        $rules['bukti_followup'] = 'nullable|image|mimes:jpeg,jpg,png,gif';
;
        if ($this->valid(Input::all(),$rules )) {
            return $this->valid( Input::all() );
        }
        $followup_tunggakan = FollowupTunggakan::find($id);
        $followup_tunggakan = $this->processData($followup_tunggakan);

        $pesan = Yoga::suksesFlash('FollowupTunggakan berhasil diupdate');
        return redirect('followup_tunggakans')->withPesan($pesan);
    }
    public function destroy($id){
        FollowupTunggakan::destroy($id);
        $pesan = Yoga::suksesFlash('FollowupTunggakan berhasil dihapus');
        return redirect('followup_tunggakans')->withPesan($pesan);
    }

    public function processData($followup_tunggakan){
        $followup_tunggakan->asuransi_id = Input::get('asuransi_id');
        $followup_tunggakan->staf_id     = Input::get('staf_id');
        $followup_tunggakan->tanggal     = convertToDatabaseFriendlyDateFormat(Input::get('tanggal'));
        $followup_tunggakan->save();
        if ( !empty( Input::get('bukti_followup') ) ) {
            $followup_tunggakan->bukti_followup = uploadFile('fu_tunggakan', 'bukti_followup', $followup_tunggakan->id, 'upload/bukti_tunggakan');
            $followup_tunggakan->save();
        }
        return $followup_tunggakan;
    }
    public function import(){
        return 'Not Yet Handled';
        $file      = Input::file('file');
        $file_name = $file->getClientOriginalName();
        $file->move('files', $file_name);
        $results   = Excel::load('files/' . $file_name, function($reader){
            $reader->all();
        })->get();
        $followup_tunggakans     = [];
        $timestamp = date('Y-m-d H:i:s');
        foreach ($results as $result) {
            $followup_tunggakans[] = [

                // Do insert here

                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];
        }
        FollowupTunggakan::insert($followup_tunggakans);
        $pesan = Yoga::suksesFlash('Import Data Berhasil');
        return redirect()->back()->withPesan($pesan);
    }
    private function valid( $data ,$rules = []){
        $messages = [
            'required' => ':attribute Harus Diisi',
        ];
        $rules = [
            "asuransi_id"    => "required",
            "staf_id"        => "required",
            "tanggal"        => 'required|date_format:d-m-Y',
        ];
        $validator = \Validator::make($data, $rules, $messages);
        
        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }
    }
}
