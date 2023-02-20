<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CekListDikerjakan;
use App\Models\CekListRuangan;
use App\Models\WhatsappBot;
use App\Http\Controllers\CekListHariansController;
use Input;
use App\Models\Classes\Yoga;
use DB;
class CekListBulananController extends Controller
{
    public $no_telp;
    public function index(){
        $frekuensi_id = 3;
        $ruangans  = CekListRuangan::where('frekuensi_cek_id', $frekuensi_id)->groupBy('ruangan_id')->get();
        $cek_lists = CekListRuangan::where('frekuensi_cek_id', $frekuensi_id)->get();
        return view('cek_list_harians.index', compact(
            'ruangans', 
            'frekuensi_id', 
            'cek_lists'
        ));
    }
    public function create(){
        $bulanan = true;
        return view('cek_list_harians.create', compact('bulanan'));
    }
    public function edit($id){
        $cek_list_bulanan = CekListDikerjakan::find($id);
        return view('cek_list_bulanans.edit', compact('cek_list_bulanan'));
    }
    public function store(Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }

        if ( $this->masihAdaYangBelumCekListBulanIni() ) {
            $whatsapp_bot = new WhatsappBot;
            $this->processData($whatsapp_bot);
            $pesan = Yoga::suksesFlash('Permintaan cek list sudah dikirim');
        } else {
            $pesan = Yoga::gagalFlash('Semua cek list sudah dikerjakan hari ini');
        }

        return redirect()->back()->withPesan($pesan);
        return redirect('cek_list_bulanans')->withPesan($pesan);
    }
    public function update($id, Request $request){
        if ($this->valid( Input::all() )) {
            return $this->valid( Input::all() );
        }
        $cek_list_bulanan = CekListDikerjakan::find($id);
        $cek_list_bulanan = $this->processData($cek_list_bulanan);

        $pesan = Yoga::suksesFlash('CekListDikerjakan berhasil diupdate');
        return redirect('cek_list_bulanans')->withPesan($pesan);
    }
    public function destroy($id){
        CekListDikerjakan::destroy($id);
        $pesan = Yoga::suksesFlash('CekListDikerjakan berhasil dihapus');
        return redirect('cek_list_bulanans')->withPesan($pesan);
    }

    public function processData($whatsapp_bot){
        $this->no_telp                         = '62' . substr(Input::get('no_telp'), 1) ;
        $whatsapp_bot->whatsapp_bot_service_id = 5;
        $whatsapp_bot->staf_id                 = Input::get('staf_id');
        $whatsapp_bot->no_telp                 = $this->no_telp;
        $whatsapp_bot->save();

        $cek     = $this->cekListBelumDilakukan();
        $message = "Silahkan mulai cek " . $cek->cekList->cek_list . " di ruangan " . $cek->ruangan->nama;
        $wa      = new WablasController;
        $wa->sendSingle( $whatsapp_bot->no_telp, $message);
    }
    public function import(){
        return 'Not Yet Handled';
        // run artisan : php artisan make:import CekListDikerjakanImport 
        // di dalam file import :
        // use App\Models\CekListDikerjakan;
        // use Illuminate\Support\Collection;
        // use Maatwebsite\Excel\Concerns\ToCollection;
        // use Maatwebsite\Excel\Concerns\WithHeadingRow;
        // class CekListDikerjakanImport implements ToCollection, WithHeadingRow
        // {
        // 
        //     public function collection(Collection $rows)
        //     {
        //         return $rows;
        //     }
        // }

        $rows = Excel::toArray(new CekListDikerjakanImport, Input::file('file'))[0];
        $cek_list_bulanans     = [];
        $timestamp = date('Y-m-d H:i:s');
        foreach ($results as $result) {
            $cek_list_bulanans[] = [

                // Do insert here

                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];
        }
        CekListDikerjakan::insert($cek_list_bulanans);
        $pesan = Yoga::suksesFlash('Import Data Berhasil');
        return redirect()->back()->withPesan($pesan);
    }
    private function valid( $data ){
        $messages = [
            'required' => ':attribute Harus Diisi',
        ];
        $rules = [
            'no_telp'           => 'required',
            'staf_id'           => 'required'
        ];
        $validator = \Validator::make($data, $rules, $messages);
        
        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }
    }

    public function masihAdaYangBelumCekListBulanIni(){
        $cek_list_ruangan_bulanan_ids  = CekListRuangan::where('frekuensi_cek_id', 3)->pluck('id');
        $cek_list_dikerjakan_hari_ini = CekListDikerjakan::where('created_at', 'like', date('Y-m') . '%')
                                                        ->whereIn('cek_list_ruangan_id', $cek_list_ruangan_bulanan_ids)
                                                        ->whereNotNull('jumlah')
                                                        ->whereNotNull('image')
                                                        ->groupBy('cek_list_ruangan_id')
                                                        ->get();
        return $cek_list_ruangan_bulanan_ids->count() !== $cek_list_dikerjakan_hari_ini->count();
    }
    public function cekListBelumDilakukan(){
        $cek_list_ruangan_bulanans = CekListRuangan::with('cekList', 'ruangan')
                                    ->where('frekuensi_cek_id', 3) // bulanan
                                    ->orderBy('ruangan_id', 'asc')
                                    ->orderBy('cek_list_id', 'asc')
                                    ->get();
        $cek_list_ruangan_ids = [];
        foreach ($cek_list_ruangan_bulanans as $cek) {
            $cek_list_ruangan_ids[] = $cek->id;
        }
        $cek_list_bulanans_dikerjakans = CekListDikerjakan::whereIn('cek_list_ruangan_id', $cek_list_ruangan_ids)
                                                        ->where('created_at', 'like', date('Y-m') . '%')
                                                        ->whereNotNull('jumlah')
                                                        ->whereNotNull('image')
                                                        ->groupBy('cek_list_ruangan_id')
                                                        ->get();
        if ( $cek_list_ruangan_bulanans->count() !== $cek_list_bulanans_dikerjakans->count() ) {

            WhatsappBot::where('no_telp', $this->no_telp)
                ->where('whatsapp_bot_service_id', 5)
                ->update([
                'whatsapp_bot_service_id' => 6
            ]);

            foreach ($cek_list_ruangan_bulanans as $cek) {
                $cek_list_dikerjakan = $this->cekListDikerjakanUntukCekListRuanganIni( $cek->id );
                if ( 
                    is_null(  $cek_list_dikerjakan  )
                ) {
                    return $cek;
                    break;
                }
            }
        }
    }

    public function cekListDikerjakanUntukCekListRuanganIni( $cek_list_ruangan_id ){
        return CekListDikerjakan::where('cek_list_ruangan_id',  $cek_list_ruangan_id )
                            ->where('created_at', 'like', date('Y-m') . '%')
                            ->whereNull('image')
                            ->whereNull('jumlah')
                            ->first();

    }
}
