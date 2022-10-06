<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sertifikat;
use Input;
use Carbon\Carbon;
use App\Models\Classes\Yoga;
use DB;

class SertifikatController extends Controller
{
    public function index(){
        return view('sertifikats.index');
    }
    public function create(){
        return view('sertifikats.create');
    }
    public function edit($id){
        $sertifikat = Sertifikat::find($id);
        return view('sertifikats.edit', compact('sertifikat'));
    }
    public function store(Request $request){
        $rules['url'] = 'required|max:10000|mimes:pdf';

        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }

        $sertifikat = new Sertifikat;
        $sertifikat = $this->processData($sertifikat);

        $pesan = Yoga::suksesFlash('Sertifikat baru berhasil dibuat');
        return redirect('sertifikats')->withPesan($pesan);
    }
    public function update($id, Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $sertifikat = Sertifikat::find($id);
        $sertifikat = $this->processData($sertifikat);

        $pesan = Yoga::suksesFlash('Sertifikat berhasil diupdate');
        return redirect('sertifikats')->withPesan($pesan);
    }
    public function destroy($id){
        Sertifikat::destroy($id);
        $pesan = Yoga::suksesFlash('Sertifikat berhasil dihapus');
        return redirect('sertifikats')->withPesan($pesan);
    }

    public function processData($sertifikat){
        $sertifikat->tanggal_terbit = Carbon::CreateFromFormat('d-m-Y', Input::get('tanggal_terbit'))->format('Y-m-d');;;
        $sertifikat->expiry_date    = Carbon::CreateFromFormat('d-m-Y', Input::get('expiry_date'))->format('Y-m-d');;
        $sertifikat->staf_id        = Input::get('staf_id');
        $sertifikat->save();
        if ( Input::hasFile('url') ) {
            $sertifikat->url     = uploadFile('serti', 'url', $sertifikat->id, 'upload/sertifikat');
            $sertifikat->save();
        }

        return $sertifikat;
    }
    public function import(){
        return 'Not Yet Handled';
        $file      = Input::file('file');
        $file_name = $file->getClientOriginalName();
        $file->move('files', $file_name);
        $results   = Excel::load('files/' . $file_name, function($reader){
            $reader->all();
        })->get();
        $sertifikats     = [];
        $timestamp = date('Y-m-d H:i:s');
        foreach ($results as $result) {
            $sertifikats[] = [

                // Do insert here

                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];
        }
        Sertifikat::insert($sertifikats);
        $pesan = Yoga::suksesFlash('Import Data Berhasil');
        return redirect()->back()->withPesan($pesan);
    }

    private function valid( $data, $rules = [] ){
        $messages = [
            'required' => ':attribute Harus Diisi',
        ];
        $rules['nama']           = 'required';
        $rules['staf_id']        = 'required';
        $rules['tanggal_terbit'] = 'required|date_format:d-m-Y';

        $validator = \Validator::make($data, $rules, $messages);
        
        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }
    }
    public function search(){
        $count = $this->searchQuery(true)[0]->jumlah;
        return [
            'data'  => $this->searchQuery(false),
            'pages' => ceil( $count/ Input::get('displayed_rows') ),
            'key'   => Input::get('key'),
            'rows'  => $count
        ];
    }

    /**
     * undocumented function
     *
     * @return void
     */
    private function searchQuery($count)
    {
        $pass           = Input::get('key') * Input::get('displayed_rows');
        $nama           = Input::get('nama');
        $staf_id        = Input::get('staf_id');
        $id             = Input::get('id');
        $tanggal_terbit = Input::get('tanggal_terbit');
        $expiry_date    = Input::get('expiry_date');

        $query  = "SELECT ";
        if (!$count) {

            $query .= "str.id, ";
            $query .= "str.url, ";
            $query .= "str.nama, ";
            $query .= "str.tanggal_terbit, ";
            $query .= "str.expiry_date, ";
            $query .= "stf.nama as nama_staf ";

        } else {

            $query .= "count(str.id) as jumlah ";

        }

        $query .= "FROM sertifikats as str ";
        $query .= "JOIN stafs as stf on stf.id = str.staf_id ";
        $query .= "WHERE str.tenant_id = " . session()->get('tenant_id') . " ";

        if (!empty($tanggal)) {
            $query .= "AND tanggal_terbit like '{$tanggal_terbit}%' ";
        }
        if (!empty($id)) {
            $query .= "AND str.id like '{$id}%' ";
        }
        if (!empty($nama)) {
            $query .= "AND str.nama like '%{$nama}%' ";
        }
        if (!empty($staf_id)) {
            $query .= "AND staf_id = {$staf_id} ";
        }
        if (!empty($tanggal_terbit)) {
            $query .= "AND tanggal_terbit like '{$tanggal_terbit}%' ";
        }
        if (!empty($expiry_date)) {
            $query .= "AND expiry_date like '{$expiry_date}%' ";
        }
        if (!$count) {
            $query .= "LIMIT {$pass},  " . Input::get('displayed_rows');
        }

        return DB::select($query);
    }
    
    
}
