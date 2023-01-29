<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KonsultasiEstetikOnline;
use Input;
// use Excel;
// use App\Imports\KonsultasiEstetikOnlineImport;
use App\Models\Classes\Yoga;
use DB;
class KonsultasiEstetikOnlineController extends Controller
{
    public static function boot(){
        parent::boot();
        self::created(function($model){
            $model->tenant_id = 1;
            $model->save();
        });
    }
    
    public function index(){
        $konsultasi_estetik_onlines = KonsultasiEstetikOnline::all();
        return view('konsultasi_estetik_onlines.index', compact(
            'konsultasi_estetik_onlines'
        ));
    }
    public function create(){
        return view('konsultasi_estetik_onlines.create');
    }
    public function show($id){
        $konsultasi_estetik_online = KonsultasiEstetikOnline::with('gambarPeriksa')->where('id',$id)->first();
        return view('konsultasi_estetik_onlines.show', compact('konsultasi_estetik_online'));
    }
    public function edit($id){
        $konsultasi_estetik_online = KonsultasiEstetikOnline::find($id);
        return view('konsultasi_estetik_onlines.edit', compact('konsultasi_estetik_online'));
    }
    public function store(Request $request){
        dd( Input::all() );
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $konsultasi_estetik_online = new KonsultasiEstetikOnline;
        $konsultasi_estetik_online = $this->processData($konsultasi_estetik_online);

        $pesan = Yoga::suksesFlash('KonsultasiEstetikOnline baru berhasil dibuat');
        return redirect('konsultasi_estetik_onlines')->withPesan($pesan);
    }
    public function update($id, Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $konsultasi_estetik_online = KonsultasiEstetikOnline::find($id);
        $konsultasi_estetik_online = $this->processData($konsultasi_estetik_online);

        $pesan = Yoga::suksesFlash('KonsultasiEstetikOnline berhasil diupdate');
        return redirect('konsultasi_estetik_onlines')->withPesan($pesan);
    }
    public function destroy($id){
        KonsultasiEstetikOnline::destroy($id);
        $pesan = Yoga::suksesFlash('KonsultasiEstetikOnline berhasil dihapus');
        return redirect('konsultasi_estetik_onlines')->withPesan($pesan);
    }

    public function processData($konsultasi_estetik_online){
        dd( 'processData belum diatur' );
        $konsultasi_estetik_online = $this->konsultasi_estetik_online;
        $konsultasi_estetik_online->save();

        return $konsultasi_estetik_online;
    }
    public function import(){
        return 'Not Yet Handled';
        // run artisan : php artisan make:import KonsultasiEstetikOnlineImport 
        // di dalam file import :
        // use App\Models\KonsultasiEstetikOnline;
        // use Illuminate\Support\Collection;
        // use Maatwebsite\Excel\Concerns\ToCollection;
        // use Maatwebsite\Excel\Concerns\WithHeadingRow;
        // class KonsultasiEstetikOnlineImport implements ToCollection, WithHeadingRow
        // {
        // 
        //     public function collection(Collection $rows)
        //     {
        //         return $rows;
        //     }
        // }

        $rows = Excel::toArray(new KonsultasiEstetikOnlineImport, Input::file('file'))[0];
        $konsultasi_estetik_onlines     = [];
        $timestamp = date('Y-m-d H:i:s');
        foreach ($results as $result) {
            $konsultasi_estetik_onlines[] = [

                // Do insert here

                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];
        }
        KonsultasiEstetikOnline::insert($konsultasi_estetik_onlines);
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
