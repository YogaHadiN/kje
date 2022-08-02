<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DenominatorBpjs;
use Input;
use Carbon\Carbon;
use App\Models\Classes\Yoga;
use DB;

class DenominatorBpjsController extends Controller
{
    /**
     * @param 
     */
    public $jumlah_peserta;
    public $denominator_dm;
    public $denominator_ht;
    public $bulanTahun;
    
    public function __construct()
    {
        $this->jumlah_peserta = Input::get('jumlah_peserta');
        $this->denominator_dm = Input::get('denominator_dm');
        $this->denominator_ht = Input::get('denominator_ht');
        $this->bulanTahun     = !is_null(Input::get('bulanTahun')) ? Carbon::createFromFormat('m-Y', Input::get('bulanTahun'))->format('Y-m-d') : null;
    }
    
    public function index(){
        $denominator_bpjs = DenominatorBpjs::all();
        return view('denominator_bpjs.index', compact(
            'denominator_bpjs'
        ));
    }
    public function create(){
        return view('denominator_bpjs.create');
    }
    public function edit($id){
        $denominator_bpjs = DenominatorBpjs::find($id);
        return view('denominator_bpjs.edit', compact('denominator_bpjs'));
    }
    public function store(Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $denominator_bpjs = new DenominatorBpjs;
        $denominator_bpjs = $this->processData($denominator_bpjs);

        $pesan = Yoga::suksesFlash('DenominatorBpjs baru berhasil dibuat');
        return redirect('denominator_bpjs')->withPesan($pesan);
    }
    public function update($id, Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $denominator_bpjs = DenominatorBpjs::find($id);
        $denominator_bpjs = $this->processData($denominator_bpjs);

        $pesan = Yoga::suksesFlash('DenominatorBpjs berhasil diupdate');
        return redirect('denominator_bpjs')->withPesan($pesan);
    }
    public function destroy($id){
        DenominatorBpjs::destroy($id);
        $pesan = Yoga::suksesFlash('DenominatorBpjs berhasil dihapus');
        return redirect('denominator_bpjs')->withPesan($pesan);
    }

    public function processData($denominator_bpjs){
        $denominator_bpjs->jumlah_peserta = $this->jumlah_peserta;
        $denominator_bpjs->denominator_dm = $this->denominator_dm;
        $denominator_bpjs->denominator_ht = $this->denominator_ht;
        $denominator_bpjs->bulanTahun     = $this->bulanTahun;
        $denominator_bpjs->save();
        return $denominator_bpjs;
    }
    public function import(){
        return 'Not Yet Handled';
        $file      = Input::file('file');
        $file_name = $file->getClientOriginalName();
        $file->move('files', $file_name);
        $results   = Excel::load('files/' . $file_name, function($reader){
            $reader->all();
        })->get();
        $denominator_bpjs     = [];
        $timestamp = date('Y-m-d H:i:s');
        foreach ($results as $result) {
            $denominator_bpjs[] = [

                // Do insert here

							'tenant_id'  => session()->get('tenant_id'),
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];
        }
        DenominatorBpjs::insert($denominator_bpjs);
        $pesan = Yoga::suksesFlash('Import Data Berhasil');
        return redirect()->back()->withPesan($pesan);
    }
    private function valid( $data ){
        $messages = [
            'required' => ':attribute Harus Diisi',
        ];
        $rules = [
            'jumlah_peserta' => 'required|numeric',
            'denominator_dm' => 'required|numeric',
            'denominator_ht' => 'required|numeric',
            'bulanTahun'     => 'required|date_format:m-Y|before:' . date('Y-m', strtotime("+1 months", strtotime("NOW"))) 
        ];
        $validator = \Validator::make($data, $rules, $messages);
        
        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }
    }
}
