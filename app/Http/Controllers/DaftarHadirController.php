<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DaftarHadir;
use Input;
// use Excel;
// use App\Imports\DaftarHadirImport;
use App\Models\Classes\Yoga;
use DB;
class DaftarHadirController extends Controller
{
    public function index(){
        $query  = "SELECT ";
        $query .= "daf.tanggal as tanggal, ";
        $query .= "stf.nama as nama_staf, ";
        $query .= "daf.waktu_hadir as waktu_hadir, ";
        $query .= "daf.waktu_hadir_id as waktu_hadir_id ";
        $query .= "FROM daftar_hadirs daf ";
        $query .= "JOIN stafs as stf on stf.id = daf.staf_id ";
        $query .= "JOIN waktu_hadirs as wak on wak.id = daf.waktu_hadir_id ";
        $data = DB::select($query);
        $daftar_hadirs = [];
        foreach ($data as $d) {
            $data[$d->tanggal][$d->waktu_hadir_id][] = [
                'nama'        => $d->nama_staf,
                'waktu_hadir' => $d->waktu_hadir
            ];
        }

        return view('daftar_hadirs.index', compact(
            'daftar_hadirs'
        ));
    }
    public function create(){
        return view('daftar_hadirs.create');
    }
    public function edit($id){
        $daftar_hadir = DaftarHadir::find($id);
        return view('daftar_hadirs.edit', compact('daftar_hadir'));
    }
    public function store(Request $request){
        dd( Input::all() );
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $daftar_hadir = new DaftarHadir;
        $daftar_hadir = $this->processData($daftar_hadir);

        $pesan = Yoga::suksesFlash('DaftarHadir baru berhasil dibuat');
        return redirect('daftar_hadirs')->withPesan($pesan);
    }
    public function update($id, Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $daftar_hadir = DaftarHadir::find($id);
        $daftar_hadir = $this->processData($daftar_hadir);

        $pesan = Yoga::suksesFlash('DaftarHadir berhasil diupdate');
        return redirect('daftar_hadirs')->withPesan($pesan);
    }
    public function destroy($id){
        DaftarHadir::destroy($id);
        $pesan = Yoga::suksesFlash('DaftarHadir berhasil dihapus');
        return redirect('daftar_hadirs')->withPesan($pesan);
    }

    public function processData($daftar_hadir){
        dd( 'processData belum diatur' );
        $daftar_hadir = $this->daftar_hadir;
        $daftar_hadir->save();

        return $daftar_hadir;
    }
    public function import(){
        return 'Not Yet Handled';
        // run artisan : php artisan make:import DaftarHadirImport 
        // di dalam file import :
        // use App\Models\DaftarHadir;
        // use Illuminate\Support\Collection;
        // use Maatwebsite\Excel\Concerns\ToCollection;
        // use Maatwebsite\Excel\Concerns\WithHeadingRow;
        // class DaftarHadirImport implements ToCollection, WithHeadingRow
        // {
        // 
        //     public function collection(Collection $rows)
        //     {
        //         return $rows;
        //     }
        // }

        $rows = Excel::toArray(new DaftarHadirImport, Input::file('file'))[0];
        $daftar_hadirs     = [];
        $timestamp = date('Y-m-d H:i:s');
        foreach ($results as $result) {
            $daftar_hadirs[] = [

                // Do insert here

                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];
        }
        DaftarHadir::insert($daftar_hadirs);
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
