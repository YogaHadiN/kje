<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PesertaBpjsPerusahaan;
use Input;
use Excel;
use App\Models\Classes\Yoga;
use App\Models\Perusahaan;
use App\Imports\PesertaBpjsPerusahaanImport;
use DB;
class PesertaBpjsPerusahaanController extends Controller
{
    public function index(){
        $peserta_bpjs_perusahaans = PesertaBpjsPerusahaan::all();
        return view('peserta_bpjs_perusahaans.index', compact(
            'peserta_bpjs_perusahaans'
        ));
    }
    public function create(){
        return view('peserta_bpjs_perusahaans.create');
    }
    public function edit($id){
        $peserta_bpjs_perusahaan = PesertaBpjsPerusahaan::find($id);
        return view('peserta_bpjs_perusahaans.edit', compact('peserta_bpjs_perusahaan'));
    }
    public function store(Request $request){
        dd( Input::all() );
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $peserta_bpjs_perusahaan = new PesertaBpjsPerusahaan;
        $peserta_bpjs_perusahaan = $this->processData($peserta_bpjs_perusahaan);

        $pesan = Yoga::suksesFlash('PesertaBpjsPerusahaan baru berhasil dibuat');
        return redirect('peserta_bpjs_perusahaans')->withPesan($pesan);
    }
    public function update($id, Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $peserta_bpjs_perusahaan = PesertaBpjsPerusahaan::find($id);
        $peserta_bpjs_perusahaan = $this->processData($peserta_bpjs_perusahaan);

        $pesan = Yoga::suksesFlash('PesertaBpjsPerusahaan berhasil diupdate');
        return redirect('peserta_bpjs_perusahaans')->withPesan($pesan);
    }
    public function destroy($id){
        PesertaBpjsPerusahaan::destroy($id);
        $pesan = Yoga::suksesFlash('PesertaBpjsPerusahaan berhasil dihapus');
        return redirect('peserta_bpjs_perusahaans')->withPesan($pesan);
    }

    public function processData($peserta_bpjs_perusahaan){
        dd( 'processData belum diatur' );
        $peserta_bpjs_perusahaan = $this->peserta_bpjs_perusahaan;
        $peserta_bpjs_perusahaan->save();

        return $peserta_bpjs_perusahaan;
    }
    public function import($id){
        $rows = Excel::toArray(new PesertaBpjsPerusahaanImport, Input::file('file'))[0];
        $perusahaan = Perusahaan::find( $id );
        $data = [];
        foreach ($rows as $r) {
            $data[] = [
                'nama' => $r['nama'],
                'nomor_asuransi_bpjs' => filter_var($r['nomor_asuransi_bpjs'], FILTER_SANITIZE_NUMBER_INT)
            ];
        }
        $perusahaan->peserta()->createMany($data);
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
