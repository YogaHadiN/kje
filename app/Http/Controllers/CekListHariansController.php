<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruangan;
use Input;
use DB;
use Log;
use App\Models\CekHarianAnafilaktikKit;
use App\Http\Controllers\WablasController;
use App\Models\Classes\Yoga;
use App\Models\CekListDikerjakan;
use App\Models\WhatsappBot;
use App\Models\CekListRuangan;

class CekListHariansController extends Controller
{
    public $cek_list_ruangan_harians;
    
    public function index(){
        $ruangans = CekListRuangan::where('frekuensi_cek_id', 1)->groupBy('ruangan_id')->get();

        $query  = "SELECT date(cld.created_at) as tanggal ";
        $query .= "FROM cek_list_dikerjakans as cld ";
        $query .= "JOIN cek_list_ruangans as clg on clg.id = cld.cek_list_ruangan_id ";
        $query .= "WHERE clg.frekuensi_cek_id = 1 ";
        $query .= "GROUP BY date(cld.created_at) ";
        $query .= "ORDER BY cld.id desc;";
        $cek_list_dikerjakans_by_tanggal = DB::select($query);

        return view('cek_list_harians.index', compact(
            'ruangans'
        ));
    }
    public function show($ruangan_id){
        $ruangan = Ruangan::with(
            'cekListRuangan',
        )
        ->where('id', $ruangan_id)->first();
        return view('cek_list_harians.show', compact(
            'ruangan',
        ));
    }
    public function create(){
       return view('cek_list_harians.create'); 
    }
    
    public function store(){
        $messages = [
            'required' => ':attribute Harus Diisi',
        ];
        $rules = [
            'no_telp' => 'required|numeric',
        ];

        $validator = \Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }
        
        if ( $this->masihAdaYangBelumCekListHariIni() ) {
            $whatsapp_bot = new WhatsappBot;
            $this->processData($whatsapp_bot);
            $pesan = Yoga::suksesFlash('Permintaan cek list sudah dikirim');
        } else {
            $pesan = Yoga::gagalFlash('Semua cek list sudah dikerjakan hari ini');
        }

        return redirect()->back()->withPesan($pesan);
    }

    public function processData($whatsapp_bot){
        $this->no_telp                         = '62' . substr(Input::get('no_telp'), 1) ;
        $whatsapp_bot->whatsapp_bot_service_id = 1;
        $whatsapp_bot->staf_id                 = Input::get('staf_id');
        $whatsapp_bot->no_telp                 = $this->no_telp;
        $whatsapp_bot->save();

        $cek     = $this->cekListBelumDilakukan();
        if (!is_null( $cek )) {
            $message = "Silahkan mulai cek " . $cek->cekList->cek_list . " di ruangan " . $cek->ruangan->nama;
            $wa      = new WablasController;
            $wa->sendSingle( $whatsapp_bot->no_telp, $message);
        }
    }
    public function masihAdaYangBelumCekListHariIni(){
        $cek_list_ruangan_harian_ids  = CekListRuangan::where('frekuensi_cek_id', 1)->pluck('id');
        $cek_list_dikerjakan_hari_ini = CekListDikerjakan::where('created_at', 'like', date('Y-m-d') . '%')
                                                        ->whereIn('cek_list_ruangan_id', $cek_list_ruangan_harian_ids)
                                                        ->whereNotNull('jumlah')
                                                        ->whereNotNull('image')
                                                        ->groupBy('cek_list_ruangan_id')
                                                        ->get();

        return $cek_list_ruangan_harian_ids->count() !== $cek_list_dikerjakan_hari_ini->count();
    }
    public function cekListBelumDilakukan(){
        if ( $this->masihAdaCekListHarianBelumDikerjakan() ) {
            WhatsappBot::where('no_telp', $this->no_telp)
                ->where('whatsapp_bot_service_id',1)
                ->update([
                'whatsapp_bot_service_id' => 2
            ]);
            foreach ($this->cek_list_ruangan_harians as $cek) {
                $cek_list_dikerjakan = $this->cekListDikerjakanUntukCekListRuanganIni( $cek->id );
                if ( is_null(  $cek_list_dikerjakan  )) {
                    return $cek;
                    break;
                }
            }
        }
    }
    public function cekListDikerjakanUntukCekListRuanganIni( $cek_list_ruangan_id ){
        return CekListDikerjakan::where('cek_list_ruangan_id',  $cek_list_ruangan_id )
                            ->where('created_at', 'like', date('Y-m-d') . '%')
                            ->whereNull('image')
                            ->whereNull('jumlah')
                            ->first();
    }
    public function masihAdaCekListHarianBelumDikerjakan(){
        $this->cek_list_ruangan_harians = CekListRuangan::harian();
        $cek_list_ruangan_ids = [];
        foreach ($this->cek_list_ruangan_harians as $cek) {
            $cek_list_ruangan_ids[] = $cek->id;
        }
        $cek_list_harians_dikerjakans = CekListDikerjakan::whereIn('cek_list_ruangan_id', $cek_list_ruangan_ids)
                                                        ->where('created_at', 'like', date('Y-m-d') . '%')
                                                        ->groupBy('cek_list_ruangan_id')
                                                        ->get();
        return $this->cek_list_ruangan_harians->count() !== $cek_list_harians_dikerjakans->count();
    
    }

    public function search(){
		$data          = $this->queryData();
		$count         = $this->queryData(true);
		$pages = ceil( $count/ Input::get('displayed_rows') );
		return [
			'data'  => $data,
			'pages' => $pages,
			'key'   => Input::get('key'),
			'rows'  => $count
		];
    }
    /**
     * undocumented function
     *
     * @return void
     */
    private function queryData($count = false){
        $tanggal          = Input::get('tanggal');
        $displayed_rows = Input::get('displayed_rows');
        $key            = Input::get('key');
		$pass           = $key * $displayed_rows;

		$query  = "SELECT ";
		if (!$count) {
            $query .= "date(cld.created_at) as tanggal ";
		} else {
			$query .= "count(cld.id) as jumlah ";
		}
        $query .= "FROM cek_list_dikerjakans as cld ";
        $query .= "JOIN cek_list_ruangans as clg on clg.id = cld.cek_list_ruangan_id ";
        $query .= "WHERE clg.frekuensi_cek_id = 1 ";
        if (!empty( $tanggal )) {
            $query .= "AND cld.created_at like '{$tanggal}%' ";
        }
		$query .= "AND cld.tenant_id = " . session()->get('tenant_id') . " ";
        $query .= "GROUP BY date(cld.created_at) ";
		if (!$count) {
            $query .= "ORDER BY cld.id desc ";
			$query .= " LIMIT {$pass}, {$displayed_rows}";
		}
		$query .= ";";

        if (!empty( $displayed_rows )) {
            $query_result = DB::select($query);
            if (!$count) {
                return $query_result;
            } else {
                return $query_result[0]->jumlah;
            }
        }
    }
}


