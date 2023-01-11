<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalKonsultasi;
use Input;
use DB;
// use Excel;
// use App\Imports\JadwalKonsultasiImport;
use App\Models\Classes\Yoga;
class JadwalKonsultasiController extends Controller
{
    public function index(){
        $jadwal_konsultasis = JadwalKonsultasi::all();
        return view('jadwal_konsultasis.index', compact(
            'jadwal_konsultasis'
        ));
    }
    public function create(){
        return view('jadwal_konsultasis.create');
    }
    public function edit($id){
        $jadwal_konsultasi = JadwalKonsultasi::find($id);
        return view('jadwal_konsultasis.edit', compact('jadwal_konsultasi'));
    }
    public function store(Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $jadwal_konsultasi = new JadwalKonsultasi;
        $jadwal_konsultasi = $this->processData($jadwal_konsultasi);

        $pesan = Yoga::suksesFlash('JadwalKonsultasi baru berhasil dibuat');
        return redirect('jadwal_konsultasis')->withPesan($pesan);
    }
    public function update($id, Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $jadwal_konsultasi = JadwalKonsultasi::find($id);
        $jadwal_konsultasi = $this->processData($jadwal_konsultasi);

        $pesan = Yoga::suksesFlash('JadwalKonsultasi berhasil diupdate');
        return redirect('jadwal_konsultasis')->withPesan($pesan);
    }
    public function destroy($id){
        JadwalKonsultasi::destroy($id);
        $pesan = Yoga::suksesFlash('JadwalKonsultasi berhasil dihapus');
        return redirect('jadwal_konsultasis')->withPesan($pesan);
    }

    public function processData($jadwal_konsultasi){
        $jadwal_konsultasi->staf_id            = Input::get("staf_id");
        $jadwal_konsultasi->tipe_konsultasi_id = Input::get("tipe_konsultasi_id");
        $jadwal_konsultasi->hari_id            = Input::get("hari_id");
        $jadwal_konsultasi->jam_mulai          = Input::get("jam_mulai");
        $jadwal_konsultasi->jam_akhir          = Input::get("jam_akhir");
        $jadwal_konsultasi->save();

        return $jadwal_konsultasi;
    }
    public function import(){
        return 'Not Yet Handled';
        // run artisan : php artisan make:import JadwalKonsultasiImport 
        // di dalam file import :
        // use App\Models\JadwalKonsultasi;
        // use Illuminate\Support\Collection;
        // use Maatwebsite\Excel\Concerns\ToCollection;
        // use Maatwebsite\Excel\Concerns\WithHeadingRow;
        // class JadwalKonsultasiImport implements ToCollection, WithHeadingRow
        // {
        // 
        //     public function collection(Collection $rows)
        //     {
        //         return $rows;
        //     }
        // }

        $rows = Excel::toArray(new JadwalKonsultasiImport, Input::file('file'))[0];
        $jadwal_konsultasis     = [];
        $timestamp = date('Y-m-d H:i:s');
        foreach ($results as $result) {
            $jadwal_konsultasis[] = [

                // Do insert here

                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];
        }
        JadwalKonsultasi::insert($jadwal_konsultasis);
        $pesan = Yoga::suksesFlash('Import Data Berhasil');
        return redirect()->back()->withPesan($pesan);
    }
    private function valid( $data ){
        $messages = [
            'required' => ':attribute Harus Diisi',
        ];
        $rules = [
            "staf_id"            => "required",
            "tipe_konsultasi_id" => "required",
            "hari_id"            => "required",
            "jam_mulai"          => "required|date_format:H:i",
            "jam_akhir"          => "required|date_format:H:i|after:jam_mulai",
        ];
        $validator = \Validator::make($data, $rules, $messages);
        
        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }
    }
}
