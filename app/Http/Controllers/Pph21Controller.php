<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Pph21;
use App\Models\BayarGaji;
use Input;
use Carbon\Carbon;
use App\Models\Classes\Yoga;
use DB;

class Pph21Controller extends Controller
{
    public function index(){
        return view('pph21s.index');
    }
    public function indexByMonth(){
        $bulanTahun = Input::get('tahun') . '-' . Input::get('bulan');
        $query  = "SELECT ";
        $query .= "st.nama, ";
        $query .= "sum(bg.gaji_pokok + bg.bonus) as gaji, ";
        $query .= "sum(pph.pph21) as pph21 ";
        $query .= "FROM bayar_gajis as bg ";
        $query .= "JOIN pph21s as pph on pph.pph21able_id = bg.id ";
        $query .= "JOIN stafs as st on st.id = bg.staf_id ";
        $query .= "WHERE pph21able_type = 'App\\\Models\\\BayarGaji' ";
        $query .= "AND bg.akhir like '{$bulanTahun}%' ";
        $query .= "GROUP BY bg.staf_id;";
        $gajis  = DB::select($query);

        /* dd( $gajis ); */
        $query  = "SELECT ";
        $query .= "'drg. Sukma' as nama, ";
        $query .= "sum(nilai) as gaji, ";
        $query .= "sum(pph.pph21) as pph21 ";
        $query .= "FROM bagi_gigis as bg ";
        $query .= "JOIN pph21s as pph on pph.pph21able_id = bg.id ";
        $query .= "WHERE pph21able_type = 'App\\\Models\\\BagiGigi' ";
        $query .= "AND bg.akhir like '{$bulanTahun}%' ";
        $query .= "GROUP BY YEAR(bg.tanggal_dibayar), MONTH(bg.tanggal_dibayar)";
        $bagi_gigis = DB::select($query);

        $datas = [];
        foreach ($gajis as $gaji) {
            $datas[] = $gaji;
        }
        foreach ($bagi_gigis as $bagi) {
            $datas[] = $bagi;
        }

        /* dd( $datas ); */
        return view('pph21s.indexByMonth', compact(
            'datas', 'bulanTahun'
        ));


    }
    public function create(){
        return view('pph21s.create');
    }
    public function edit($id){
        $pph21 = Pph21::find($id);
        return view('pph21s.edit', compact('pph21'));
    }
    public function store(Request $request){
        dd( Input::all() );
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $pph21 = new Pph21;
        $pph21 = $this->processData($pph21);

        $pesan = Yoga::suksesFlash('Pph21 baru berhasil dibuat');
        return redirect('pph21s')->withPesan($pesan);
    }
    public function update($id, Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $pph21 = Pph21::find($id);
        $pph21 = $this->processData($pph21);

        $pesan = Yoga::suksesFlash('Pph21 berhasil diupdate');
        return redirect('pph21s')->withPesan($pesan);
    }
    public function destroy($id){
        Pph21::destroy($id);
        $pesan = Yoga::suksesFlash('Pph21 berhasil dihapus');
        return redirect('pph21s')->withPesan($pesan);
    }

    public function processData($pph21){
        dd( 'processData belum diatur' );
        $pph21 = $this->pph21;
        $pph21->save();

        return $pph21;
    }
    public function import(){
        return 'Not Yet Handled';
        $file      = Input::file('file');
        $file_name = $file->getClientOriginalName();
        $file->move('files', $file_name);
        $results   = Excel::load('files/' . $file_name, function($reader){
            $reader->all();
        })->get();
        $pph21s     = [];
        $timestamp = date('Y-m-d H:i:s');
        foreach ($results as $result) {
            $pph21s[] = [

                // Do insert here

                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];
        }
        Pph21::insert($pph21s);
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

    public function pph21Detil($staf_id, $bulanTahun){

        $bayar_gajis = BayarGaji::with('pph21s')
                                ->where('staf_id', $staf_id)
                                ->where('tanggal_dibayar', 'like' , $bulanTahun . '%')
                                ->get();

        return view('pph21s.detil', compact(
            'bayar_gajis'
        ));
    }
}
