<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SentEmail;
use Input;
use App\Models\Classes\Yoga;
use DB;
class SentEmailController extends Controller
{
    public function index(){
        $sent_emails = SentEmail::all();
        return view('sent_emails.index', compact(
            'sent_emails'
        ));
    }
    public function create(){
        return view('sent_emails.create');
    }
    public function edit($id){
        $sent_email = SentEmail::find($id);
        return view('sent_emails.edit', compact('sent_email'));
    }
    public function store(Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $sent_email = new SentEmail;
        $sent_email = $this->processData($sent_email);

        $pesan = Yoga::suksesFlash('SentEmail baru berhasil dibuat');
        return redirect('sent_emails')->withPesan($pesan);
    }
    public function update($id, Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $sent_email = SentEmail::find($id);
        $sent_email = $this->processData($sent_email);

        $pesan = Yoga::suksesFlash('SentEmail berhasil diupdate');
        return redirect('sent_emails')->withPesan($pesan);
    }
    public function destroy($id){
        SentEmail::destroy($id);
        $pesan = Yoga::suksesFlash('SentEmail berhasil dihapus');
        return redirect('sent_emails')->withPesan($pesan);
    }

    public function processData($sent_email){
        $sent_email->staf_id = Input::get('staf_id');
        $sent_email->tanggal = convertToDatabaseFriendlyDateFormat(Input::get('tanggal'));
        $sent_email->subject = Input::get('subject');
        $sent_email->body    = Input::get('body');
        $sent_email->email   = Input::get('email');
        $sent_email->save();

        return $sent_email;
    }
    public function import(){
        return 'Not Yet Handled';
        $file      = Input::file('file');
        $file_name = $file->getClientOriginalName();
        $file->move('files', $file_name);
        $results   = Excel::load('files/' . $file_name, function($reader){
            $reader->all();
        })->get();
        $sent_emails     = [];
        $timestamp = date('Y-m-d H:i:s');
        foreach ($results as $result) {
            $sent_emails[] = [

                // Do insert here

                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];
        }
        SentEmail::insert($sent_emails);
        $pesan = Yoga::suksesFlash('Import Data Berhasil');
        return redirect()->back()->withPesan($pesan);
    }
    private function valid( $data ){
        $messages = [
            'required' => ':attribute Harus Diisi',
        ];
        $rules = [
            'email'   => 'required|email',
            'staf_id' => 'required',
            'tanggal' => 'required|date_format:d-m-Y',
            'subject' => 'required',
            'body'    => 'required',
        ];
        $validator = \Validator::make($data, $rules, $messages);
        
        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }
    }
}
