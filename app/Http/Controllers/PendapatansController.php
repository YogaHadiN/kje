<?php

namespace App\Http\Controllers;

use Input;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Classes\Yoga;
use App\Models\Periksa;
use App\Models\Console\Commands\testcommand;
use App\Models\Http\Requests;
use App\Models\Rules\noLaterThan;
use App\Models\Rules\FormatExcelBenar;
use App\Models\Rules\TanggalDibayarHarusLebihLamaDariPelayanan;
use App\Models\Http\Controllers\AsuransisController;
use App\Models\Pendapatan;
use App\Models\PembayaranBpjs;
use App\Models\Invoice;
use App\Models\Rekening;
use App\Models\PembayaranAsuransi;
use App\Models\PiutangDibayar;
use App\Models\NotaJual;
use App\Models\Imports\PembayaranImport;
use App\Models\Rules\HarusMelaluiRekening;
use App\Models\Rules\pembayaranAsuransiHarusSama;
use App\Models\Coa;
use App\Models\Asuransi;
use App\Models\JurnalUmum;
use App\Models\CatatanAsuransi;
use DB;
use Carbon\Carbon;

class PendapatansController extends Controller
{
	public $input_dibayar;
	public $input_mulai;
	public $input_staf_id;
	public $input_akhir;
	public $input_tanggal_dibayar;
	public $input_asuransi_id;
	public $input_temp;
	public $input_coa_id;
	public $input_catatan_container;
	public $input_rekening_id;
	public $input_invoice_id;
	public $input_id;
	public $input_created_at;
	public $input_coa_id_asuransi;
	public $input_nama_asuransi;
	public $input_awal_periode;
	public $input_akhir_periode;
	public $input_pembayaran;
	public $input_tanggal_pembayaran;
	public $input_tujuan_kas;
	public $input_displayed_rows;
	public $input_pass;
	public $input_key;
	public $input_kata_kunci;

	/**
	 * Display a listing of pendapatans
	 *
	 * @return Response
	 */
	public function __construct(){

		$this->input_dibayar           = Yoga::clean(Input::get('dibayar'));
		$this->input_mulai             = Input::get('mulai');
		$this->input_staf_id           = Input::get('staf_id');
		$this->input_akhir             = Input::get('akhir');
		$this->input_tanggal_dibayar   = Input::get('tanggal_dibayar');
		$this->input_asuransi_id       = Input::get('asuransi_id');
		$this->input_temp              = Input::get('temp');
		$this->input_coa_id            = Input::get('coa_id');
		$this->input_catatan_container = Input::get('catatan_container');
		$this->input_rekening_id       = Input::get('rekening_id');
		$this->input_invoice_id        = Input::get('invoice_id');
		$this->input_key               = Input::get('key');
		$this->input_kata_kunci        = Input::get('kata_kunci');

		$this->input_id                 = Input::get('id'). '%';
		$this->input_created_at         = Input::get('created_at'). '%';
		$this->input_nama_asuransi      = '%' .Input::get('nama_asuransi'). '%';
		$this->input_awal_periode       = Input::get('awal_periode');
		$this->input_akhir_periode      = Input::get('akhir_periode');
		$this->input_pembayaran         = Input::get('pembayaran'). '%';
		$this->input_tanggal_pembayaran = Input::get('tanggal_pembayaran'). '%';
		$this->input_tujuan_kas         = $this->strSplit(Input::get('tujuan_kas'));
		$this->input_displayed_rows     = Input::get('displayed_rows');
		$this->input_pass               = $this->input_key * $this->input_displayed_rows;


		 $this->middleware('keuangan', ['only' => [
			 'pembayaran_bpjs', 
			 'pembayaran_bpjs_post'
		 ]]);
	}
	public function index()
	{
		$pendapatans = Pendapatan::all();
		return view('pendapatans.index', compact('pendapatans'));
	}

	/**
	 * Show the form for creating a new pendapatan
	 *
	 * @return Response
	 */
	public function create()
	{
		$asuransis          = '';
		foreach(Asuransi::where('id', '>', 0)->get() as $ass){
			if (count( explode(".", $ass->nama ) ) > 1) {
				$text       = explode(".", $ass->nama )[1] ;
			} else {
				$text       = $ass->nama;
			}
			$text           = str_replace(")","",$text);
			$text           = str_replace("(","",$text);
			$text           = trim($text);
			if ($text) {
				$asuransis .= strtolower($text) . ' ';
			}
		}
		$asuransis          = explode(" ", $asuransis);

		$coa_ids = [
			110000 => 'Kas di kasir',
			110001 => 'Kas di Bank Mandiri',
			110003 => 'Kas di Bank BCA'
		];


		$pendapatans        = Pendapatan::with('staf')->latest()->paginate(10);

		return view('pendapatans.create', compact('pendapatans','asuransis', 'coa_ids'));
	}

	/**
	 * Store a newly created pendapatan in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = [

			'sumber_uang' => 'required',
			'nilai'       => 'required',
			'coa_id'       => 'required',
			'staf_id'     => 'required',
			'keterangan'  => 'required',
		];
		$validator = \Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		//return Input::all();
		$nilai                   = Yoga::clean( Input::get('nilai') );
		$pendapatan              = new Pendapatan;
		$pendapatan->sumber_uang = Input::get('sumber_uang');
		$pendapatan->nilai       = $nilai;
		$pendapatan->keterangan  = Input::get('keterangan');
		$pendapatan->staf_id     = Input::get('staf_id');
		$confirm                 = $pendapatan->save();

		if ($confirm) {
			$jurnal                  = new JurnalUmum;
			$jurnal->jurnalable_id   = $pendapatan->id; // kenapa ini nilainya empty / null padahal di database ada id
			$jurnal->jurnalable_type = 'App\Models\Pendapatan';
			$jurnal->coa_id          = Input::get('coa_id');
			$jurnal->debit           = 1;
			$jurnal->nilai           = $nilai;
			$jurnal->save();

			$jurnal                  = new JurnalUmum;
			$jurnal->jurnalable_id   = $pendapatan->id;
			$jurnal->jurnalable_type = 'App\Models\Pendapatan';
			$jurnal->debit           = 0;
			$jurnal->nilai           = $nilai;
			$jurnal->save();
		}

		return redirect('pendapatans/create')->withPesan(Yoga::suksesFlash('Pendapatan telah berhasil dimasukkan'))
			->withPrint($pendapatan->id);
	}

	/**
	 * Display the specified pendapatan.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$pendapatan = Pendapatan::findOrFail($id);

		return view('pendapatans.show', compact('pendapatan'));
	}

	/**
	 * Show the form for editing the specified pendapatan.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$pendapatan = Pendapatan::find($id);

		return view('pendapatans.edit', compact('pendapatan'));
	}

	/**
	 * Update the specified pendapatan in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$pendapatan = Pendapatan::findOrFail($id);

		$validator = \Validator::make($data = Input::all(), Pendapatan::$rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		$pendapatan->update($data);

		return \Redirect::route('pendapatans.index');
	}

	/**
	 * Remove the specified pendapatan from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Pendapatan::destroy($id);

		return \Redirect::route('pendapatans.index');
	}
    public function pembayaran_asuransi(){
		return $this->pembayaran_asuransi_template();
    }
    public function pembayaran_asuransi_by_id($id){
        return 'asuransi '. $id;
         return 'pembayaran_asuransi';
    }

    public function pembayaran_asuransi_show($id){
        $pembayarans = NotaJual::find($id)->pembayaranAsuransi; 
        return view('pendapatans.pembayaran_show', compact('pembayarans'));

        $asuransi_id  = Input::get('asuransi_id');
        $asuransi     = Asuransi::find($asuransi_id);
        $mulai        = Yoga::nowIfEmptyMulai(Input::get('mulai'));
        $akhir        = Yoga::nowIfEmptyAkhir(Input::get('akhir'));
		$query        = "select ";
		$query       .= "px.id as id, ";
		$query       .= "ps.nama as nama, ";
		$query       .= "asu.nama as nama_asuransi, ";
		$query       .= "asu.id as asuransi_id, ";
		$query       .= "px.tanggal as tanggal, ";
		$query       .= "px.piutang as piutang, ";
		$query       .= "px.piutang_dibayar as piutang_dibayar , ";
		$query       .= "px.piutang_dibayar as piutang_dibayar_awal ";
		$query       .= "from periksas as px ";
		$query       .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query       .= "join asuransis as asu on asu.id=px.asuransi_id ";
		$query       .= "where px.asuransi_id='{$asuransi_id}' ";
		$query       .= "and px.tanggal between '{$mulai}' and '{$akhir}';";
        $periksas     = DB::select($query);
        
		$query     = "SELECT ";
		$query    .= "px.id as id, ";
		$query    .= "p.nama as nama, asu.nama as nama_asuransi,";
		$query    .= " asu.id as asuransi_id, ";
		$query    .= "px.tanggal as tanggal, ";
		$query    .= "px.piutang as piutang, ";
		$query    .= "px.piutang_dibayar as piutang_dibayar , ";
		$query    .= "px.piutang_dibayar as piutang_dibayar_awal ";
		$query    .= "from periksas as px ";
		$query    .= "join pasiens as p on px.pasien_id = p.id ";
		$query    .= "join asuransis as asu on asu.id = px.asuransi_id ";
		$query    .= "where px.piutang > 0 ";
		$query    .= "and px.piutang > px.piutang_dibayar ";
		$query    .= "and px.asuransi_id = '{$id}';";
		$periksas  = DB::select($query);

		return view('pendapatans.pembayaran_show', compact(
			'asuransi', 
			'periksas', 
			'mulai', 
			'akhir'
		));
    }
	public function belumDibayar($mulai, $akhir, $id){
		
		$query = "SELECT px.id as piutang_id, ";
		$query .= "px.id as periksa_id, ";
		$query .= "px.pasien_id as pasien_id, ";
		$query .= "ps.nama as nama_pasien, ";
		$query .= "px.tunai as tunai, ";
		$query .= "px.invoice_id as invoice_id, ";
		$query .= "px.piutang as piutang, ";
		$query .= "pd.pembayaran_asuransi_id as pembayaran_asuransi_id, ";
		$query .= "COALESCE(sum(pd.pembayaran),0) as pembayaran, ";
		$query .= "COALESCE(sum(pd.pembayaran),0) as total_pembayaran, ";
		$query .= "0 as akan_dibayar, ";
		$query .= "px.tanggal as tanggal ";
		$query .= "from periksas as px ";
		$query .= "left join piutang_dibayars as pd on pd.periksa_id=px.id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where date(px.tanggal) between '{$mulai}' and '{$akhir}' ";
		$query .= "and px.asuransi_id = '{$id}' ";
		$query .= "group by px.id ";
		$query .= "order by px.tanggal;";

        $result = DB::select($query);
		return $result;
	}
	

    public function lihat_pembayaran_asuransi(){
		return $this->lihat_pembayaran_asuransi_template();
    }
	public function sudahDibayar( $mulai, $akhir, $asuransi_id ){
		
		$query = "SELECT px.id as piutang_id, ";
		$query .= "pd.id as piutang_dibayar_id, ";
		$query .= "px.id as periksa_id, ";
		$query .= "ps.nama as nama_pasien, ";
		$query .= "ps.id as pasien_id, ";
		$query .= "px.tunai as tunai, ";
		$query .= "px.piutang as piutang, ";
		$query .= "COALESCE(sum(pd.pembayaran),0) as pembayaran, ";
		$query .= "COALESCE(sum(pd.pembayaran),0) as sudah_dibayar, ";
		$query .= "0 as akan_dibayar, ";
		$query .= "px.tanggal as tanggal ";
		$query .= "from periksas as px ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "join piutang_dibayars as pd on pd.periksa_id = px.id ";
		$query .= "where date(px.tanggal) between '{$mulai} 00:00:00' and '{$akhir} 23:59:59' ";
		$query .= "and px.asuransi_id = '{$asuransi_id}' ";
		$query .= "GROUP BY px.id ";
		$query .= "having sudah_dibayar >= piutang ";
		$query .= "order by px.tanggal;";
        return DB::select($query);
	}
	
    public function asuransi_bayar(Request $request){
		/* dd(Input::all()); */ 
		DB::beginTransaction();
		try {
			$rules = [
				 'tanggal_dibayar' => ['date','required', new TanggalDibayarHarusLebihLamaDariPelayanan($request)],
				 'mulai'           => ['date','required'],
				 'akhir'           => ['date','required'],
				 'staf_id'         => 'required',
				 'dibayar'         => ['required', new pembayaranAsuransiHarusSama($request) ], 
				 'asuransi_id'     => ['required'],
				 'coa_id'          => ['required']
			];

			$asuransi = Asuransi::find( Input::get('asuransi_id') );
			$messages = [];
			if ( $asuransi->pelunasan_tunai < 1 ) {
				$rules['rekening_id']       = 'required';
				$nama_asuransi = $asuransi->nama;
				$messages = [
					'rekening_id.required' => 'Asuransi <strong>' . $nama_asuransi. '</strong> dibayar melalui transfer dan harus menyertakan rekening_id'
				];
			}

			$validator = \Validator::make(Input::all(), $rules, $messages);
			if ($validator->fails())
			{
				return \Redirect::back()->withErrors($validator)->withInput();
			}

			$this->input_coa_id_asuransi = $asuransi->coa_id;
			$data = $this->inputData();
			$pesan = Yoga::suksesFlash('Asuransi <strong>' . $asuransi->nama . '</strong> tanggal <strong>' . Yoga::updateDatePrep($data['mulai']). '</strong> sampai dengan <strong>' . Yoga::updateDatePrep($data['akhir']) . ' BERHASIL</strong> dibayarkan sebesar <strong><span class="uang">' . $data['dibayar'] . '</span></strong>');
			DB::commit();
			if ($data['coa_id'] == '110000') {
				return redirect('pendapatans/pembayaran/asuransi')->withPesan($pesan)->withPrint($data['pb']->id);
			} else {
				return redirect('pendapatans/pembayaran/asuransi')->withPesan($pesan);
			}
		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}
    }
	public function pembayaran_bpjs(){
		$bpjs = PembayaranBpjs::orderBy('tanggal_pembayaran', 'desc')->get();
		return view('pembayaran_bpjs.index', compact( 'bpjs' ));
	}
	public function pembayaran_bpjs_post(Request $request){
		$messages = [
			'required' => ':attribute Harus Diisi',
		];
		$rules = [
			'staf_id'            => [ 'required'],
			'tanggal_pembayaran' => [ 'required','date_format:d-m-Y', new noLaterThan($request)],
			'periode_bulan'      => [ 'required','date_format:m-Y'],
			'nilai'              => [ 'required']
		];

		$validator = \Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		$nilai               = Yoga::clean( Input::get('nilai') );
		$staf_id             = Input::get('staf_id');
		$tanggal_pembayaran  = Yoga::datePrep( Input::get('tanggal_pembayaran') );
		$periode_bulan       = Yoga::blnPrep( Input::get('periode_bulan') );
		$hari_terakhir_bulan = date('Y-m-t 23:59:59', strtotime($periode_bulan . '-01'));

		$bpjs = new PembayaranBpjs;
		$bpjs->staf_id = Input::get('staf_id');
		$bpjs->nilai = $nilai;
		$bpjs->mulai_tanggal = $periode_bulan . '-01 00:00:00';
		$bpjs->akhir_tanggal = $hari_terakhir_bulan;
		$bpjs->tanggal_pembayaran = $tanggal_pembayaran;
		$confirm = $bpjs->save();

		if ($confirm) {
			
			$jurnal                  = new JurnalUmum;
			$jurnal->jurnalable_id   = $bpjs->id; // kenapa ini nilainya empty / null padahal di database ada id
			$jurnal->jurnalable_type = 'App\Models\PembayaranBpjs';
			$jurnal->coa_id          = 110004;
			$jurnal->debit           = 1;
			$jurnal->created_at      = $hari_terakhir_bulan;
			$jurnal->updated_at      = $hari_terakhir_bulan;
			$jurnal->nilai           = $nilai;
			$jurnal->save();

			$jurnal                  = new JurnalUmum;
			$jurnal->jurnalable_id   = $bpjs->id;
			$jurnal->jurnalable_type = 'App\Models\PembayaranBpjs';
			$jurnal->coa_id          =  400045 ;// pendapatan kapitasi bpjs
			$jurnal->debit           = 0;
			$jurnal->created_at      = $hari_terakhir_bulan;
			$jurnal->updated_at      = $hari_terakhir_bulan;
			$jurnal->nilai           = $nilai;
			$jurnal->save();

		}
		$pesan = Yoga::suksesFlash('Input pembayaran kapitasi bpjs bulan ' . $periode_bulan . ' telah berhasil');
		return redirect()->back()->withPesan($pesan);
	}
	public function pembayaran_asuransi_rekening($id){
		return $this->pembayaran_asuransi_template($id);
	}
	private function pembayaran_asuransi_template($id = null){
		/* if ($id) { */
		$asuransi_list = Asuransi::pluck('nama', 'id')->all();
		/* } else { */
		/* 	$asuransis = Asuransi::where('pelunasan_tunai', 1)->get(); */
		/* 	$asuransi_list = []; */
		/* 	foreach ($asuransis as $asuransi) { */
		/* 		$asuransi_list[ $asuransi->id ] = $asuransi->nama; */
		/* 	} */
		/* } */
        $pembayarans   = PembayaranAsuransi::with('asuransi', 'coa')->latest()->paginate(10);
		if ($id) {
			$rekening = Rekening::find( $id );
			return view('pendapatans.pembayaran_asuransi', compact('asuransi_list', 'pembayarans', 'rekening'));
		} else {
			return view('pendapatans.pembayaran_asuransi', compact('asuransi_list', 'pembayarans'));
		}
	}
	public function lihat_pembayaran_asuransi_by_rekening($id, Request $request){

		$rules = [
			'excel_pembayaran' => ['nullable', new FormatExcelBenar($request) ]
		];

		$validator = \Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}

		return $this->lihat_pembayaran_asuransi_template($id);
	}
	private function lihat_pembayaran_asuransi_template($id = null){


        $asuransi_id = Input::get('asuransi_id');
		$invoices = $this->invoicesQuery($asuransi_id);
		if(count($invoices)){
			foreach ($invoices as $inv) {
				$option_invoices[$inv->invoice_id] = $inv->invoice_id;
			}
		} else {
			$option_invoices = [];
		}

		$total_sudah_dibayar = 0;
		$total_belum_dibayar = 0;

        $mulai       = Yoga::datePrep( Input::get('mulai') );
        $akhir       = Yoga::datePrep( Input::get('akhir') );

        $kasList     = [ null => '-Pilih-' ] + Coa::where('id', 'like', '110%')->pluck('coa', 'id')->all();

        $pembayarans = $this->belumDibayar($mulai, $akhir, $asuransi_id);

        foreach ($pembayarans as $k => $pemb) {
            if ($pemb->pembayaran == null) {
                $pembayarans[$k]->pembayaran = 0;
            }
			$total_belum_dibayar += $pemb->piutang - $pemb->pembayaran;
        }

        $asuransi              = Asuransi::find($asuransi_id);
		$PendapatansController = new PendapatansController;
		$asuransis             = new AsuransisController;
		/* $hutangs               = $asuransis->hutangs_template($asuransi_id); */
		$pembayarans_template  = $asuransis->pembayarans_template($asuransi_id);

        $sudah_dibayars = $this->sudahDibayar( $mulai, $akhir, $asuransi_id );

		$excel_pembayaran = [];

		if (Input::hasFile('excel_pembayaran')) {
			$file =Input::file('excel_pembayaran'); //GET FILE
			$excel_pembayaran = Excel::toArray(new PembayaranImport, $file)[0];
		}  

		foreach ($sudah_dibayars as $sb) {
			$total_sudah_dibayar += $sb->pembayaran;
		}

		$arus_kas_tujuan = null;
		$tanggal_dibayar = null;
		$cari_transaksis = [];
		if (isset($id)) {
			$rekening        = Rekening::find( $id );
			$tanggal_dibayar = Carbon::CreateFromFormat('Y-m-d H:i:s',$rekening->tanggal)->format('d-m-Y');
			$arus_kas_tujuan = 110001;

			if (Input::hasFile('excel_pembayaran')) {
				$query  = "SELECT ";
				$query .= "psn.nama as nama, ";
				$query .= "prx.piutang as piutang, ";
				$query .= "prx.tanggal as tanggal, ";
				$query .= "prx.asuransi_id as asuransi_id ";
				$query .= "FROM periksas as prx ";
				$query .= "JOIN pasiens as psn on psn.id = prx.pasien_id ";
				$query .= "WHERE (";
				foreach ($excel_pembayaran as $k => $xcl) {
					if (!empty($xcl[0])) {
						$query .= "( REPLACE(REPLACE(psn.nama, '.', ''), ' ', '') like '" . str_replace(' ', '', str_replace('.', '', $xcl[0])). "%' and prx.piutang = " . rpToNumber($xcl[1]). " ) ";
						if (count($excel_pembayaran) -1 != $k) {
							$query .= "or ";
						} else {
							$query .= ")";
						}
					}
				}
				$query .= "AND prx.asuransi_id = '{$asuransi_id}' ";
				$query .= "AND prx.tanggal < '{$rekening->tanggal}' ";
				$query .= "ORDER BY tanggal desc;";
				$cari_transaksis = DB::select($query);
			}  
		}
		$new_excel_pembayaran = [];
		foreach ($excel_pembayaran as $x) {
			$new_excel_pembayaran[] = [
				0 => $x[0],
				1 => rpToNumber($x[1])
			];
		}

		$excel_pembayaran = $new_excel_pembayaran;
		$excel_pembayaran = json_encode($excel_pembayaran);

		$param = compact( 
			'pembayarans', 
			'total_sudah_dibayar', 
			'excel_pembayaran', 
			'arus_kas_tujuan', 
			'tanggal_dibayar', 
			'total_belum_dibayar', 
			'cari_transaksis', 
			'asuransi', 
			'sudah_dibayars', 
			'option_invoices', 
			'mulai', 
			'akhir', 
			'asuransi_id', 
			/* 'hutangs', */ 
			'pembayarans_template', 
			'kasList'
		);
		if ( isset($id) ) {
			$param['rekening'] = $rekening;
			$param['id']       = $id;
		}

		return view('pendapatans.pembayaran_show', $param);
	}
	public function detailPA(){
		$id     = Input::get('id');
		$id     = json_decode($id, true);
		$result = [];
		if (count($id)) {
			$invoices = Invoice::with('periksa.asuransi')->whereIn('id', $id )->get();
			foreach ($invoices as $invoice) {
				$result[] = $invoice->detail_invoice;
			}
		}
		return $result;
	}
	public function invoicesQuery($asuransi_id, $nilai = false){
		$query  = "SELECT ";
		$query .= "inv.id as invoice_id, ";
		if ($nilai) {
			$query .= "sum(px.piutang - pd.pembayaran) as total_tagihan ";
		} else {
			$query .= "count(px.piutang - pd.pembayaran) as total_tagihan ";
		}
		$query .= "FROM invoices as inv ";
		$query .= "JOIN periksas as px on px.invoice_id = inv.id ";
		$query .= "JOIN piutang_dibayars as pd on pd.periksa_id = px.id ";
		$query .= "WHERE px.asuransi_id = '{$asuransi_id}' ";
		$query .= "AND inv.pembayaran_asuransi_id is null ";
		$query .= "GROUP BY inv.id";
		if ($nilai) {
			$query .= " HAVING sum(px.piutang - pd.sudah_dibayar) = {$nilai} LIMIT 1;";
		} else {
			$query .= ";";
		}
		return DB::select($query);
	}
	public function inputData(){

		$dibayar           = $this->input_dibayar;
		$mulai             = $this->input_mulai;
		$staf_id           = $this->input_staf_id;
		$akhir             = $this->input_akhir;
		$tanggal           = Yoga::datePrep( $this->input_tanggal_dibayar );
		$asuransi_id       = $this->input_asuransi_id;
		$temp              = $this->input_temp;
		$coa_id            = $this->input_coa_id;
		$catatan_container = $this->input_catatan_container;
		$catatan_container = json_decode($catatan_container, true) ;
		
		$temp = json_decode($temp, true);

		// create nota_jual

		$nota_jual_id     = Yoga::customId('App\Models\NotaJual');
		$nj               = new NotaJual;
		$nj->id           = $nota_jual_id;
		$nj->tipe_jual_id = 2;
		$nj->tanggal      = $tanggal;
		$nj->staf_id      = $staf_id;
		$nj->save();

		//create pembayaran_asuransis
		
		$pb                  = new PembayaranAsuransi;
		$pb->asuransi_id     = $asuransi_id;
		$pb->mulai           = $mulai;
		$pb->staf_id         = $staf_id;
		$pb->nota_jual_id    = $nota_jual_id;
		$pb->akhir           = $akhir;
		$pb->pembayaran      = $dibayar;
		$pb->tanggal_dibayar = $tanggal;
		$pb->kas_coa_id      = $coa_id;
		$confirm             = $pb->save();

		//update rekening
		$rekening                         = Rekening::find( $this->input_rekening_id );
		if (!is_null($rekening)) {
			$rekening->pembayaran_asuransi_id = $pb->id;
			$rekening->save();

			$validasi_kata_kunci_1        = false;
			$validasi_kata_kunci_2        = false;
			$asuransi                     = Asuransi::find( $this->input_asuransi_id );
			$deskripsi_setelah_dash       = count(explode(' - ', $rekening->deskripsi)) > 1 ? trim(explode(' - ', $rekening->deskripsi)[1]) : '';
			$string_between_two_condition = get_string_between($rekening->deskripsi, 'INW.CN-SKN CR SA-MCS', ' - ');
			$kata_kunci                   = $this->getFirstTwoWord($string_between_two_condition);
			$kata_kunci_exist             = Asuransi::where('kata_kunci', 'like', '%' . $kata_kunci . '%')->first();
			/* dd( */
			/* 	'$rekening->deskripsi', */
			/* 	$rekening->deskripsi, */
			/* 	'$asuransi->kata_kunci' , */
			/* 	$asuransi->kata_kunci , */
			/* 	"strpos($rekening->deskripsi, 'INW.CN-SKN CR SA-MCS') !== false" , */
			/* 	strpos($rekening->deskripsi, 'INW.CN-SKN CR SA-MCS') !== false , */
			/* 	'$deskripsi_setelah_dash', */
			/* 	$deskripsi_setelah_dash, */
			/* 	'preg_match("/^\d+$/", $deskripsi_setelah_dash)' , */
			/* 	preg_match("/^\d+$/", $deskripsi_setelah_dash) , */
			/* 	"strlen($deskripsi_setelah_dash)" , */
			/* 	strlen($deskripsi_setelah_dash) , */
			/* 	"str_word_count($string_between_two_condition)", */
			/* 	str_word_count($string_between_two_condition), */
			/* 	'$kata_kunci', */
			/* 	$kata_kunci */
			/* ); */
			if (
				empty($asuransi->kata_kunci) && //kata kunci asuransi belum terdefinisi
				empty($this->input_kata_kunci) && //kata kunci dalam input kosong
				strpos($rekening->deskripsi, 'INW.CN-SKN CR SA-MCS') !== false && //deskripsi mengandung 'INW.CN-SKN CR SA-MCS'
				(preg_match("/^\d+$/", $deskripsi_setelah_dash) && strlen($deskripsi_setelah_dash) == 3) && //deskripsi mengandung ' - 3 angka numerik'				
				str_word_count($string_between_two_condition) > 1 && //deskripsi kata diantara 2 kondisi tersebut memiliki 2 kata atau lebih
				is_null($kata_kunci_exist) //kata kunci belum dipakai di asuransi lain
			) {
				$validasi_kata_kunci_1 = true;
			} 
			if ( is_null($kata_kunci_exist) ) {
				$validasi_kata_kunci_2 = true;
			}
			if (
				$validasi_kata_kunci_1 &&
				$validasi_kata_kunci_2
			) {
				$asuransi->kata_kunci = $kata_kunci;
				$asuransi->save();
			} else {
				if ( !empty( $this->input_kata_kunci ) ) {
					$asuransi->kata_kunci = $this->input_kata_kunci;
					$asuransi->save();
				}
			}
		}
		//
		//update invoices
		$invoice_ids = $this->input_invoice_id;
		$invoices    = Invoice::whereIn('id', $invoice_ids)->get();
		foreach ($invoices as $inv) {
			if (isset($inv)) {
				$inv->pembayaran_asuransi_id = $pb->id;
				$inv->save();
			}
		}
		$coa_id_asuransi = $this->input_coa_id_asuransi;
		//
		// insert jurnal_umums
		if ($confirm) {
			$jurnals = [];
			$jurnals[] = [
				'jurnalable_id'   => $nota_jual_id,
				'jurnalable_type' => 'App\Models\NotaJual',
				'coa_id'          => $coa_id, //coa_kas_di_bank_mandiri = 110001;
				'debit'           => 1,
				'nilai'           => $dibayar,
				'created_at'      => date('Y-m-d H:i:s'),
				'updated_at'      => date('Y-m-d H:i:s')
			];

			$jurnals[] = [
				'jurnalable_id'   => $nota_jual_id,
				'jurnalable_type' => 'App\Models\NotaJual',
				'coa_id'          => $coa_id_asuransi,
				'debit'           => 0,
				'nilai'           => $dibayar,
				'created_at'      => date('Y-m-d H:i:s'),
				'updated_at'      => date('Y-m-d H:i:s')
			];
			JurnalUmum::insert($jurnals);
		}
		$bayars = [];
		foreach ($temp as $tmp) {
			if (
				$tmp['akan_dibayar'] > 0 &&
				$tmp['piutang'] > $tmp['pembayaran']
			) {
				//update piutang_asuransis
				$bayars[] = [
					'periksa_id'             => $tmp['periksa_id'],
					'pembayaran'             => $tmp['akan_dibayar'],
					'pembayaran_asuransi_id' => $pb->id,
					'created_at'             => date('Y-m-d H:i:s'),
					'updated_at'             => date('Y-m-d H:i:s')
				];
			}
		}
		$catatans= [];
		PiutangDibayar::insert($bayars);
		return [
			'mulai'    => $mulai,
			'akhir'    => $akhir,
			'coa_id'   => $coa_id,
			'pb'       => $pb,
			'dibayar'  => $dibayar
		];
	}
	public function cariPembayaran(){

		$data  = $this->queryData();
		$count = $this->queryData(true);
		$pages = ceil( $count/ $this->input_displayed_rows );

		return [
			'data'  => $data,
			'pages' => $pages,
			'key'   => $this->input_key,
			'rows'  => $count
		];
	}
	private function strSplit($word){
		$arr_word = str_split($word);
		$result = '%';
		foreach ($arr_word as $w) {
			$result .= $w .'%';
		}

		return $result;
	}
	private function queryData(
		$count = false
	){
		$query  = "SELECT ";
		if (!$count) {
			$query .= "pa.id, ";
			$query .= "DATE_FORMAT( pa.created_at, '%Y-%m-%d') as created_at, ";
			$query .= "asu.nama as nama_asuransi, ";
			$query .= "DATE_FORMAT( pa.mulai, '%Y-%m-%d') as awal_periode, ";
			$query .= "DATE_FORMAT( pa.akhir, '%Y-%m-%d') as akhir_periode, ";
			$query .= "concat(DATE_FORMAT( pa.mulai, '%Y-%m-%d'), ' s/d ', DATE_FORMAT( pa.akhir, '%Y-%m-%d')) as periode, ";
			$query .= "pa.pembayaran as pembayaran, ";
			$query .= "pa.tanggal_dibayar as tanggal_pembayaran, ";
			$query .= "co.coa as tujuan_kas ";
		} else {
			$query .= "count(pa.id) as jumlah ";
		}
		$query .= "FROM pembayaran_asuransis as pa ";
		$query .= "JOIN asuransis as asu on asu.id = pa.asuransi_id ";
		$query .= "JOIN coas as co on co.id = pa.kas_coa_id ";
		$query .= "WHERE pa.id like '{$this->input_id}' ";
		$query .= "AND pa.created_at like '{$this->input_created_at}' ";
		$query .= "AND asu.nama like '{$this->input_nama_asuransi}' ";
		$query .= "AND pa.mulai like '{$this->input_awal_periode}%' ";
		$query .= "AND pa.akhir like '{$this->input_akhir_periode}%' ";
		$query .= "AND pa.pembayaran like '{$this->input_pembayaran}' ";
		$query .= "AND pa.tanggal_dibayar like '{$this->input_tanggal_pembayaran}' ";
		$query .= "AND co.coa like '{$this->input_tujuan_kas}' ";
		$query .= "ORDER BY pa.id desc ";
		if (!$count) {
			$query .= "LIMIT {$this->input_pass}, {$this->input_displayed_rows};";
		}
		if (!$count) {
			return DB::select($query);
		} else {
			return DB::select($query)[0]->jumlah;
		}
	}
	public function delete_pembayaran_asuransi(){
		$pembayaran_asuransi_id  = Input::get('pembayaran_asuransi_id');
		$testCommand             = new testcommand;
		$pembayaran_asuransi_ids = [$pembayaran_asuransi_id];
		$testCommand->resetPembayaranAsuransis( $pembayaran_asuransi_ids );
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function getFirstTwoWord($string)
	{
		$words = explode(" ", $string);
		return join(" ", array_slice($words, 0, 2));
	}
	
}
