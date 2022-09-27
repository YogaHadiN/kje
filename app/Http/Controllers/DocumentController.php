<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Input;
use Carbon\Carbon;
use App\Models\Classes\Yoga;
use DB;
class DocumentController extends Controller
{
    public function index(){
        $documents = Document::all();
        return view('documents.index', compact(
            'documents'
        ));
    }

    public function create(){
        return view('documents.create');
    }

    public function edit($id){
        $document = Document::find($id);
        return view('documents.edit', compact('document'));
    }
    public function store(Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $document = new Document;
        $document = $this->processData($document);

        $pesan = Yoga::suksesFlash('Document baru berhasil dibuat');
        return redirect('documents')->withPesan($pesan);
    }
    public function update($id, Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $document = Document::find($id);
        $document = $this->processData($document);

        $pesan = Yoga::suksesFlash('Document berhasil diupdate');
        return redirect('documents')->withPesan($pesan);
    }
    public function destroy($id){
        Document::destroy($id);
        $pesan = Yoga::suksesFlash('Document berhasil dihapus');
        return redirect('documents')->withPesan($pesan);
    }

    public function processData($document){
        $document->nama    = Input::get('nama');
        $document->tanggal = Carbon::CreateFromFormat('d-m-Y', Input::get('tanggal'))->format('Y-m-d');
        $document->save();
        $document->url     = uploadFile('file', 'url', $document->id, 'upload/dokumen_penting');
        $document->save();
        return $document;
    }
    public function import(){
        return 'Not Yet Handled';
        $file      = Input::file('file');
        $file_name = $file->getClientOriginalName();
        $file->move('files', $file_name);
        $results   = Excel::load('files/' . $file_name, function($reader){
            $reader->all();
        })->get();
        $documents     = [];
        $timestamp = date('Y-m-d H:i:s');
        foreach ($results as $result) {
            $documents[] = [

                // Do insert here

                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];
        }
        Document::insert($documents);
        $pesan = Yoga::suksesFlash('Import Data Berhasil');
        return redirect()->back()->withPesan($pesan);
    }
    private function valid( $data ){
        $messages = [
            'required' => ':attribute Harus Diisi',
        ];
        $rules = [
            'nama'    => 'required',
            'tanggal' => 'required|date_format:d-m-Y',
            'url'     => 'required|max:10000|mimes:pdf',
            
        ];
        $validator = \Validator::make($data, $rules, $messages);
        
        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }
    }
    public function search(){
        $nama    = Input::get('nama');
        $id      = Input::get('id');
        $tanggal = Input::get('tanggal');
        $query  = "SELECT * ";
        $query .= "FROM documents ";
        $query .= "WHERE '' = '' ";
        if (!empty($tanggal)) {
            $query .= "AND tanggal like '{$tanggal}%' ";
        }
        if (!empty($id)) {
            $query .= "AND id like '{$id}%' ";
        }
        if (!empty($nama)) {
            $query .= "AND id like '%{$nama}%' ";
        }
        return DB::select($query);
    }
    public function deleteAjax(){
        $id = Input::get('id');
        Document::destroy($id);
    }
}
