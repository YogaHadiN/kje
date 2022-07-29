<?php
namespace App\Http\Controllers;

use Input;
use App\Http\Requests;
use Carbon\Carbon;
use Storage;
use App\Models\Asuransi;
use App\Models\Berkas;
use App\Models\Tarif;
use App\Models\TipeAsuransi;
use App\Models\Email;
use App\Models\Telpon;
use App\Models\Pic;
use App\Models\PembayaranAsuransi;
use App\Http\Controllers\CustomController;
use App\Models\Coa;
use App\Models\CatatanAsuransi;
use App\Models\TipeTindakan;
use App\Models\Classes\Yoga;
use App\Http\Requests\AsuransiValidation;

use DB;


class AsuransisController extends Controller
{

	public $input_nama;
	public $input_pic ;
	public $input_alamat;
	public $input_telpon ;
	public $input_tanggal_berakhir;
	public $input_penagihan       ;
	public $input_gigi            ;
	public $input_rujukan         ;
	public $input_tipe_asuransi_id;
	public $input_email           ;
	public $input_umum            ;
	public $input_kali_obat       ;
	public $input_kata_kunci      ;
	public $input_aktif;
	public $hasfile;
	public $input_id;
	public $input_nama_file;
	public $input_file;
	public $berkasable_type;
	public $input_folder;

	public $input_piutang;
	public $input_bulan;
	public $input_asuransi_id;
	public $input_key;
	public $input_sudah_dibayar;
	public $input_sisa;
	public $input_column_order;
	public $input_displayed_rows;
	public $input_order;

   public function __construct()
    {
        $this->middleware('super', ['only'   => 'delete']);
        $this->middleware('admin', ['except' => []]);
		$this->input_nama                     = Input::get('nama');
		$this->input_alamat                   = Input::get('alamat');
		$this->input_pic                      = Input::get('pic');
		$this->input_hp_pic                   = Input::get('hp_pic');
		$this->input_telpon                   = Input::get('telpon');
		$this->input_email                    = Input::get('email');
		$this->input_tanggal_berakhir         = Yoga::datePrep(Input::get('tanggal_berakhir'));
		$this->input_penagihan                = Yoga::cleanArrayJson(Input::get('penagihan'));
		$this->input_gigi                     = Yoga::cleanArrayJson(Input::get('gigi'));
		$this->input_rujukan                  = Yoga::cleanArrayJson(Input::get('rujukan'));
		$this->input_tipe_asuransi_id            = Input::get('tipe_asuransi_id');
		$this->input_umum                     = Yoga::cleanArrayJson(Input::get('umum'));
		$this->input_kali_obat                = Input::get('kali_obat');
		$this->input_kata_kunci               = Input::get('kata_kunci');
		$this->hasfile                        = Input::hasFile('file');
		$this->input_id                       = Input::get('asuransi_id');
		$this->input_nama_file                = Input::get('nama_file');
		$this->input_aktif                    = Input::get('aktif');
		$this->input_file                     = Input::file('file');
		$this->berkasable_type                = 'App\\Models\\Asuransi';
		$this->input_folder                   = 'asuransi';

		$this->input_piutang        = Input::get('piutang');
		$this->input_bulan          = Input::get('bulan');
		$this->input_asuransi_id    = Input::get('asuransi_id');
		$this->input_key            = Input::get('key');
		$this->input_sudah_dibayar  = Input::get('sudah_dibayar');
		$this->input_sisa           = Input::get('sisa');
		$this->input_column_order   = Input::get('column_order');
		$this->input_displayed_rows = Input::get('displayed_rows');
		$this->input_order          = Input::get('order');

    }
	/**
	 * Display a listing of asuransis
	 *
	 * @return Response
	 */
	public function index()
	{
		$asuransis = Asuransi::where('id', '>', 0)->get();

		$asur = [];

		foreach ($asuransis as $key => $asu) {
			$asur[] = [
				'id'     => $asu->id,
				'nama'   => $asu->nama,
				'alamat' => $asu->alamat,
				'pic'    => $asu->pic,
				'hp_pic' => $asu->hp_pic
			];
		}
		
		return view('asuransis.index', compact('asuransis'));
	}

	/**
	 * Show the form for creating a new asuransi
	 *
	 * @return Response
	 */
	public function create()
	{	
		$tarifs             = $this->tarifTemp()['tarif'];
		$tipe_tindakans     = TipeTindakan::all();
		$tipe_asuransi_list = $this->tipe_asuransi_list();
		$px                 = new CustomController;
		$warna              = $px->warna;
		return view('asuransis.create', compact(
			'warna', 
			'tipe_tindakans', 
			'tipe_asuransi_list', 
			'tarifs'
		));
	}

	/**
	 * Store a newly created asuransi in storage.
	 *
	 * @return Response
	 */
	public function store() {
		DB::beginTransaction();
		try {
			$asuransi         = new Asuransi;
			$asuransi         = $this->inputData($asuransi);

			$kode_coa             = (int)Coa::where('kode_coa', 'like', '111%')->orderBy('id', 'desc')->first()->kode_coa + 1;

			$coa                  = new Coa;
			$coa->kode_coa        = $kode_coa;
			$coa->kelompok_coa_id = '11';
			$coa->coa             = 'Piutang Asuransi ' . $asuransi->nama;
			$coa->save();


			$asuransi->coa_id = $coa->id;
			$asuransi->save();

			$tarifs = Input::get('tarifs');
			$tarifs = json_decode($tarifs, true);

			$data = [];

			foreach ($tarifs as $tarif_pribadi) {
				$data [] = [
					'biaya'                 => $tarif_pribadi['biaya'],
					'jenis_tarif_id'        => $tarif_pribadi['jenis_tarif_id'],
					'tipe_tindakan_id'      => $tarif_pribadi['tipe_tindakan_id'],
					'bhp_items'             => $tarif_pribadi['bhp_items'],
					'jasa_dokter'           => $tarif_pribadi['jasa_dokter'],
					'jasa_dokter_tanpa_sip' => $tarif_pribadi['jasa_dokter']
				];
			}

            $asuransi->tarif()->createMany($data);
			DB::commit();
			return \Redirect::route('asuransis.index')->withPesan(Yoga::suksesFlash('<strong>Asuransi ' . ucwords(strtolower(Input::get('nama')))  .'</strong> berhasil dibuat'));
		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}
	}

	/**
	 * Display the specified asuransi.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$asuransi = Asuransi::findOrFail($id);

		return view('asuransis.show', compact('asuransi'));
	}

	/**
	 * Show the form for editing the specified asuransi.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tarifTemp          = $this->tarifTemp($id);
		$tarifs             = $tarifTemp['tarif'];
		$tipe_tindakans     = TipeTindakan::all();
		$tipe_asuransi_list = $this->tipe_asuransi_list();
		$px                 = new CustomController;
		$warna              = $px->warna;
		$asuransi           = $tarifTemp['asuransi'];

		return view('asuransis.edit', compact(
			'asuransi', 
			'warna', 
			'tipe_tindakans', 
			'tipe_asuransi_list', 
			'tarifs'
		));
	}

	/**
	 * Update the specified asuransi in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		DB::beginTransaction();
		try {
			$asuransi = Asuransi::findOrFail($id);

			Pic::where('asuransi_id', $id)->delete();
			Email::where('emailable_id', $id)->where('emailable_type', 'App\\Models\\Asuransi')->delete();
			Telpon::where('telponable_id', $id)->where('telponable_type', 'App\\Models\\Asuransi')->delete();

			$asuransi = $this->inputData($asuransi);

			$tarifs   = Input::get('tarifs');
			$tarifs   = json_decode($tarifs, true);

			foreach ($tarifs as $tarif) {
				$tf                   = Tarif::find($tarif['id']);
				$tf->biaya            = $tarif['biaya'];
				$tf->jasa_dokter      = $tarif['jasa_dokter'];
				$tf->tipe_tindakan_id = $tarif['tipe_tindakan_id'];
				$confirm = $tf->save();

				if (!$confirm) {
					return 'update gagal';
				}
			}
			DB::commit();
			return \Redirect::route('asuransis.index')->withPesan(Yoga::suksesFlash('<strong>Asuransi ' . Input::get('nama') . '</strong> berhasil diubah'));
		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}
	}

	/**
	 * Remove the specified asuransi from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{	
		$asuransi = Asuransi::find($id);
		$nama     = $asuransi->nama;
		Tarif::where('asuransi_id', $id)->delete();
		Coa::destroy($asuransi->coa_id);
		Email::where('emailable_id', $asuransi->id)->where('emailable_type', 'App\\Models\\Asuransi')->delete();
		Pic::where('asuransi_id', $asuransi->id)->delete();
		$asuransi->delete();


		return \Redirect::route('asuransis.index')->withPesan(Yoga::suksesFlash('<strong>Asuransi ' . $nama . '</strong> berhasil dihapus'));
	}

	public function riwayat($id){

		$query  = "SELECT *, COALESCE(sum(pdb.pembayaran),0) as sudah_dibayar ";
		$query .= "FROM periksas as prx ";
		$query .= "JOIN piutang_dibayars as pdb on pdb.periksa_id = prx.id ";
		$query .= "WHERE asuransi_id = '{$id}' ";
		$query .= "AND prx.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "GROUP BY prx.id ";
		$query .= "ORDER BY prx.tanggal desc";
		$periksas = DB::select($query);

		$hutangs = [];
		foreach ($periksas as $prx) {
			$tanggal = Carbon::parse( $prx->tanggal );
			$bulan =  $tanggal->format('Y-m');
			if ( !isset($hutangs[$bulan][0]['piutang'])) {
				$hutangs[$bulan][0]['piutang'] = 0;
			}
			if ( !isset($hutangs[$bulan][0]['sudah_dibayar'])) {
				$hutangs[$bulan][0]['sudah_dibayar'] = 0;
			}
			if ( !isset($hutangs[$bulan][1]['piutang'])) {
				$hutangs[$bulan][1]['piutang'] = 0;
			}
			if ( !isset($hutangs[$bulan][1]['sudah_dibayar'])) {
				$hutangs[$bulan][1]['sudah_dibayar'] = 0;
			}

			if (
				 $tanggal->format('d') >= 1 &&
				 $tanggal->format('d') <= 15 
			) {
				$hutangs[$bulan][0]['piutang']       += $prx->piutang;
				$hutangs[$bulan][0]['sudah_dibayar'] += $prx->sudah_dibayar;
			} else {
				$hutangs[$bulan][1]['piutang']       += $prx->piutang;
				$hutangs[$bulan][1]['sudah_dibayar'] += $prx->sudah_dibayar;
			}
			
		}

		$asuransi    = Asuransi::find( $id );
		$pembayarans = $this->pembayarans_template($id);

		return view('asuransis.hutangPembayaran', compact(
			'asuransi',
			'hutangs',
			'pembayarans'
		));
	}
	public function hutangPerBulan($bulan, $tahun){

		$query  ="SELECT ";
		$query .="bl.id, ";
		$query .="bl.tanggal, ";
		$query .="bl.nama_asuransi, ";
		$query .="sum(bl.hutang) as hutang, ";
		$query .="sum(bl.sudah_dibayar) as sudah_dibayar ";
		$query .="FROM ( ";

        if (env("DB_CONNECTION") == 'mysql') {
            $query .="SELECT year(ju.created_at) as tahun, ";
        } else {
            $query .="SELECT strftime('%Y',ju.created_at) as tahun, ";
        }
        if (env("DB_CONNECTION") == 'mysql') {
            $query .="month(ju.created_at) as bulan, ";
        } else {
            $query .="strftime('%m',ju.created_at) as bulan, ";
        }

		$query .="ju.created_at as tanggal, ";
		$query .="ju.nilai as hutang, ";
		$query .="asu.nama as nama_asuransi, ";
		$query .="asu.id as id, ";
		$query .="COALESCE(sum(byr.pembayaran),0) as sudah_dibayar ";
		$query .="FROM jurnal_umums as ju ";
		$query .="join periksas as px on px.id = ju.jurnalable_id ";
		$query .="join pasiens as ps on ps.id = px.pasien_id ";
		$query .="join asuransis as asu on px.asuransi_id = asu.id ";
		$query .="left join piutang_dibayars as byr on px.id = byr.periksa_id ";
		$query .="where jurnalable_type = 'App\\\Models\\\Periksa' ";
		$query .="AND px.created_at like '{$tahun}-{$bulan}%' ";
		$query .="AND px.asuransi_id > 0 ";
		$query .="AND ju.coa_id like '111%' ";
		$query .="AND ju.debit = '1' ";
		$query .= "AND ju.tenant_id = " . session()->get('tenant_id') . " ";
		$query .="Group by ju.id) bl ";
		$query .="Group by bl.id";

		$data = DB::select($query);


		/* return $data; */
		$total_hutang = 0;
		$total_sudah_dibayar = 0;
		foreach ($data as $d) {
			$total_hutang           += $d->hutang;
			$total_sudah_dibayar    += $d->sudah_dibayar;
		}
		
		return view('asuransis.hutangPerBulan', compact(
			'data',
			'total_hutang',
			'total_sudah_dibayar',
			'tahun',
			'bulan'
		));
	}
	
	public function hutang($year){
		$query = $this->queryHutang([
			'waktu' => 'tahun',
			'param' => $year
		]);
		$data_piutang = DB::select($query);

		/* return view('asuransis.hutang', compact( */
		/* 	'data', */
		/* 	'data_piutang', */
		/* 	'total_hutang', */
		/* 	'total_sudah_dibayar', */
		/* 	'tahun', */
		/* 	'bulan' */
		/* )); */

		return view('asuransis.hutang', compact(
			'data_piutang'
		));
	}
	public function hutangs_template($id, $key){

		$pass          = $key * 8;
		$piutang       = Input::get('piutang');
		$sudah_dibayar = Input::get('sudah_dibayar');
		$sisa          = Input::get('sisa');

		$query  = "select ";
		$query .= "case ";
		$query .= "when DATE_FORMAT(px.tanggal, '%d') >= 1 and DATE_FORMAT(px.tanggal, '%d') <= 15 then concat(DATE_FORMAT(px.tanggal, '%Y-%m'), '-01')";
		$query .= "else concat(DATE_FORMAT(px.tanggal, '%Y-%m'), '-16') ";
		$query .= "end as periode, ";
		$query .= "sum(px.piutang) as piutang, ";
		$query .= "sum(pdb.sudah_dibayar) as sudah_dibayar ";
		$query .= "from periksas as px ";
		$query .= "join piutang_dibayars as pdb on pdb.periksa_id = px.id ";
		$query .= "where px.asuransi_id = '{$id}' ";
		$query .= "group by periode ";
		$query .= "having (piutang like '{$piutang}%' or '{$piutang}' = '') ";
		$query .= "and (sudah_dibayar like '{$sudah_dibayar}%' or '{$sudah_dibayar}' = '') ";
		$query .= "and (piutang - sudah_dibayar like '{$sisa}%' or '{$sisa}' = '') ";
		$query .= "AND px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "order by px.tanggal desc ";
		$total_rows = count(DB::select($query));

		$query .= "LIMIT {$pass}, 8 ";
		$result = DB::select($query);


		return [
			'result'     => $result,
			'total_rows' => $total_rows
		];
	}
	public function pembayarans_template($id){
		return PembayaranAsuransi::with('staf', 'rekening')->where('asuransi_id', $id)->orderBy('tanggal_dibayar', 'desc')->get();
	}

	public function piutangAsuransiSudahDibayar( $asuransi_id, $mulai, $akhir ){

		$asuransi             = Asuransi::find( $asuransi_id );
		$pendapatanController = new PendapatansController;
        $sudah_dibayars       = $pendapatanController->sudahDibayar( $mulai, $akhir, $asuransi_id );

		$total_tunai          = 0;
		$total_piutang        = 0;
		$total_sudah_dibayar  = 0;
		$total_sisa_piutang   = 0;

		foreach ($sudah_dibayars as $sudah) {
			$total_tunai         += $sudah->tunai;
			$total_piutang       += $sudah->piutang;
			$total_sudah_dibayar += $sudah->sudah_dibayar;
			$total_sisa_piutang  += $sudah->piutang - $sudah->sudah_dibayar;
		}

		$query  = "SELECT ";
		$query .= "peas.tanggal_dibayar as tanggal_dibayar, ";
		$query .= "peas.mulai as mulai, ";
		$query .= "peas.id as id, ";
		$query .= "peas.akhir as akhir, ";
		$query .= "peas.pembayaran as pembayaran, ";
		$query .= "peas.created_at as tanggal_input, ";
		$query .= "asu.nama as nama_asuransi, ";
		$query .= "st.nama as nama_staf, ";
		$query .= "co.coa as coa ";
		$query .= "FROM pembayaran_asuransis as peas ";
		$query .= "JOIN asuransis as asu on asu.id = peas.asuransi_id ";
		$query .= "JOIN coas as co on co.id = peas.coa_id ";
		$query .= "JOIN stafs as st on st.id = peas.staf_id ";
		$query .= "WHERE ( mulai like '" .date('Y-m', strtotime($mulai)) . '%'. "' or akhir like '" .date('Y-m', strtotime($akhir)) . '%'. "'  ) ";
		$query .= "AND peas.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "AND asu.id = '{$asuransi_id}' ";

		$pembayaran_asuransi = DB::select($query);

		$total_pembayaran= 0;

		foreach ($pembayaran_asuransi as $pem) {
			$total_pembayaran += $pem->pembayaran;
		}

		return view('asuransis.sudah_dibayar', compact(
			'asuransi',
			'mulai',
			'pembayaran_asuransi',
			'total_piutang',
			'total_tunai',
			'total_sudah_dibayar',
			'total_sisa_piutang',
			'akhir',
			'sudah_dibayars',
			'total_pembayaran'
		));
	}
	
	public function piutangAsuransiBelumDibayar($asuransi_id, $mulai, $akhir  ){
		$asuransi             = Asuransi::find( $asuransi_id );
		$pendapatanController = new PendapatansController;
        $belum_dibayars       = $pendapatanController->belumDibayar( $mulai, $akhir, $asuransi_id );

		$total_piutang       = 0;
		$total_sudah_dibayar = 0;
		$total_sisa_piutang  = 0;

		foreach ($belum_dibayars as $belum) {
			$total_piutang       += $belum->piutang;
			$total_sudah_dibayar += $belum->total_pembayaran;
			$total_sisa_piutang  += $belum->piutang - $belum->total_pembayaran;
		}

		return view('asuransis.belum_dibayar', compact(
			'asuransi',
			'mulai',
			'total_piutang',
			'total_sudah_dibayar',
			'total_sisa_piutang',
			'akhir',
			'belum_dibayars'
		));
	}
	public function riwayatHutang(){
		$hutangs = $this->hutangs_template( Input::get('asuransi_id'), Input::get('key') );
		/* $arr     = []; */
		/* foreach ($hutangs as $i => $hutang) { */
		/* 	$arr[] = [ */
		/* 		'bulan'         => Yoga::bulan($hutang->bulan), */
		/* 		'nama_asuransi' => $hutang->nama_asuransi, */
		/* 		'asuransi_id'   => $hutang->asuransi_id, */
		/* 		'sudah_dibayar' => Yoga::buatrp($hutang->sudah_dibayar), */
		/* 		'hutang'        => Yoga::buatrp($hutang->hutang), */
		/* 		'tahun'         => $hutang->tahun */
		/* 	]; */
		/* } */
		return $hutangs;

	}

	

	public function querySemuaPiutangPerBulan($asuransi_id, $mulai, $akhir  ){
		
		$query  = "SELECT ";
		$query .= "px.created_at as tanggal_periksa, ";
		$query .= "px.id as periksa_id, ";
		$query .= "ps.nama as nama_pasien, ";
		$query .= "asu.nama as nama_asuransi, ";
		$query .= "px.tunai as tunai, ";
		$query .= "px.piutang as piutang, ";
		$query .= "COALESCE(sum(pd.pembayaran),0) as sudah_dibayar ";
		$query .= "FROM periksas as px ";
		$query .= "LEFT JOIN piutang_dibayars as pd on pd.periksa_id = px.id ";
		$query .= "JOIN pasiens as ps on ps.id = px.pasien_id ";
		$query .= "JOIN asuransis as asu on asu.id = px.asuransi_id ";
		$query .= "WHERE asu.id = '{$asuransi_id}' ";
		$query .= "AND ( DATE(px.created_at) between '{$mulai}' and '{$akhir}' ) ";
		$query .= "AND px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "group by px.id";

		return DB::select($query);
	}
	



	public function piutangAsuransi($asuransi_id, $mulai, $akhir  ){


		$piutangs = $this->querySemuaPiutangPerBulan($asuransi_id, $mulai, $akhir  );

		$asuransi = Asuransi::find( $asuransi_id );

		$total_tunai         = 0;
		$total_piutang       = 0;
		$total_sudah_dibayar = 0;

		foreach ($piutangs as $piutang) {
			$total_tunai         += $piutang->tunai;
			$total_piutang       += $piutang->piutang;
			$total_sudah_dibayar += $piutang->sudah_dibayar;
		}

		return view('asuransis.semua_piutang', compact(
			'mulai',
			'asuransi',
			'akhir',
			'piutangs',
			'total_piutang',
			'total_sudah_dibayar',
			'total_tunai'
		));
	}
	
	private function inputData($asuransi){
		$asuransi->nama             = $this->input_nama;
		$asuransi->alamat           = $this->input_alamat;
		$asuransi->tanggal_berakhir = $this->input_tanggal_berakhir;
		$asuransi->tipe_asuransi_id = $this->input_tipe_asuransi_id;
		$asuransi->kali_obat        = $this->input_kali_obat;
		$asuransi->kata_kunci       = $this->input_kata_kunci;
		$asuransi->aktif            = $this->input_aktif;
		$asuransi->save();

		$timestamp = date('Y-m-d H:i:s');
		$emails = [];
		foreach ( $this->input_email as $email) {
			if ( !empty($email) ) {
				$emails[] = [
					'email'          => $email,
					'emailable_id'   => $asuransi->id,
					'emailable_type' => 'App\\Models\\Asuransi',
                    'tenant_id'      => session()->get('tenant_id'),
					'created_at'     => $timestamp,
					'updated_at'     => $timestamp
				];
			}
		}
		$pics = [];
		foreach ($this->input_pic as $k =>$pic) {
			if ( !empty( $pic ) ) {
				$pics[] = [
					'nama' => $pic,
					'nomor_telepon' => $this->input_hp_pic[$k],
					'asuransi_id' => $asuransi->id,
							'tenant_id'  => session()->get('tenant_id'),
					'created_at' => $timestamp,
					'updated_at' => $timestamp
				];
			}
		}
		$telpons = [];
		foreach ( $this->input_telpon as $telpon) {
			if ( !empty($telpon) ) {
				$telpons[] = [
					'nomor'          => $telpon,
					'telponable_id'   => $asuransi->id,
					'telponable_type' => 'App\\Models\\Asuransi',
							'tenant_id'  => session()->get('tenant_id'),
					'created_at'     => $timestamp,
					'updated_at'     => $timestamp
				];
			}
		}
		Email::insert($emails);
		Pic::insert($pics);
		Telpon::insert($telpons);
		return $asuransi;
	}
	public function kataKunciUnique(){
		$kata_kunci  = strtolower(trim(Input::get('kata_kunci')));
		$asuransi_id = Input::get('asuransi_id');
		if (empty( $kata_kunci)) {
			return '1';
		}
		if (isset( $asuransi_id )) {
			try {
				Asuransi::where('kata_kunci', $kata_kunci)->whereNot('id', $asuransi_id)->firstOrFail();
				return '0';
			} catch (\Exception $e) {
				return '1';
			}
		} else {
			try {
				Asuransi::where('kata_kunci', $kata_kunci)->firstOrFail();
				return '0';
			} catch (\Exception $e) {
				return '1';
			}
		}
	}
	public function tarifTemp($id = null){
        /* dd( $id ); */
        if (is_null($id)) {
            $asuransi = Asuransi::with('pic', 'emails', 'tarif.jenisTarif', 'tarif.tipeTindakan')->where('nama','Biaya Pribadi')->first();
        } else {
            $asuransi = Asuransi::with('pic', 'emails', 'tarif.jenisTarif', 'tarif.tipeTindakan')->where('id',$id)->first();
        }
		$trf    = $asuransi->tarif;
		$tarifs = [];
		foreach ($trf as $t) {
			$tarifs[] = [
				'jenis_tarif'           => $t->jenisTarif->jenis_tarif,
				'jenis_tarif_id'        => $t->jenis_tarif_id,
				'id'                    => $t->id,
				'jasa_dokter'           => $t->jasa_dokter,
				'tipe_tindakan_id'      => $t->tipe_tindakan_id,
				'tipe_tindakan'         => $t->tipeTindakan->tipe_tindakan,
				'bhp_items'             => $t->bhp_items,
				'jasa_dokter_tanpa_sip' => $t->jasa_dokter_tanpa_sip,
				'biaya'                 => $t->biaya
			];
		}
		return [
			'tarif' => $tarifs,
			'asuransi' => $asuransi
		];
	}
	public function uploadBerkas(){
		if($this->hasfile) {
			$id           = $this->input_id;
			$nama_file    = $this->input_nama_file;
			$upload_cover = $this->input_file;
			$extension    = $upload_cover->getClientOriginalExtension();

			$berkas                  = new Berkas;
			$berkas->berkasable_id   = $id;
			$berkas->berkasable_type = $this->berkasable_type;
			$berkas->nama_file       = $nama_file;
			$berkas->save();

			$filename =	 $berkas->id . '_' . time() . '.' . $extension;

			//menyimpan bpjs_image ke folder public/img
			//
			$destination_path =  'berkas/' . $this->input_folder . '/' . $id . '/';
			$berkas->url       = $destination_path . $filename;
			$berkas->save();


			$filename =	 $berkas->id . '_' . time() . '.' . $extension;

			//menyimpan bpjs_image ke folder public/img
			//
			$destination_path =  'berkas/' . $this->input_folder . '/' . $id . '/';
			/* $destination_path = public_path() . DIRECTORY_SEPARATOR . 'berkas/' . $this->input_folder . '/' . $id . '/'; */

			// Mengambil file yang di upload
			//
			//
			/* return [$filename, $destination_path]; */

			/* $upload_cover->move($destination_path , $filename); */
			Storage::disk('s3')->put($destination_path. $filename, file_get_contents($upload_cover));
			return $berkas->url;
			
		} else {
			return null;
		}
	}
	public function hapusBerkas(){
		$berkas_id = Input::get('berkas_id');
		if ( Berkas::destroy( $berkas_id ) ) {
			return '1';
		} else {
			return '0';
		}
	}
	private function tipe_asuransi_list(){
		$tipe_asuransi_list = [];
		foreach (TipeAsuransi::all() as $k => $value) {
			$tipe_asuransi_list[$value->id] = $value->tipe_asuransi;
		}
		return $tipe_asuransi_list;
	}
	public function	queryHutang($param){
		$waktu         = $param['waktu'];
		$param         = $param['param'];

		$three_months_ago = date('Y-m-d', strtotime($param . ' -3 month'));
		$year_three_months_ago = date('Y', strtotime($three_months_ago));

		$query  = "SELECT ";
		$query .= "bl.tanggal, ";
		$query .= "bl.bulan, ";
		$query .= "bl.tahun, ";
		$query .= "sum(bl.hutang) as piutang, ";
		$query .= "sum(bl.sudah_dibayar) as sudah_dibayar ";
		$query .= "FROM ( ";
		$query .= "SELECT ";
        if (env("DB_CONNECTION") == 'mysql') {
            $query .= "year(ju.created_at) as tahun,";
        } else {
            $query .="strftime('%Y',ju.created_at) as tahun, ";
        }
        if (env("DB_CONNECTION") == 'mysql') {
            $query .= " month(ju.created_at) as bulan,";
        } else {
            $query .="strftime('%m',ju.created_at) as bulan, ";
        }
		$query .= " ju.created_at as tanggal,";
		$query .= " ju.nilai as hutang,";
		$query .= " COALESCE(sum(byr.pembayaran),0) as sudah_dibayar";
		$query .= " FROM jurnal_umums as ju";
		$query .= " join periksas as px on px.id = ju.jurnalable_id";
		$query .= " join pasiens as ps on ps.id = px.pasien_id";
		$query .= " join asuransis as asu on px.asuransi_id = asu.id";
		$query .= " left join piutang_dibayars as byr on px.id = byr.periksa_id";
		$query .= " where jurnalable_type = 'App\\\Models\\\Periksa'";
		$query .= " AND px.asuransi_id > 0";
		$query .= " AND ju.coa_id like '111%'";
		$query .= "AND ju.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= " AND ju.debit = '1'";
		if ( $waktu == 'tahun' ) {
			$query .= " AND px.tanggal like '{$param}%' ";
		} else if ( $waktu == '3bulan' ) {
			$param = Carbon::createFromFormat('Y-m-d', $param);
			$query .= " AND px.tanggal between '" . $year_three_months_ago . '-' . $param->copy()->format('01-01 00:00:00') . "' and '{$param->copy()->subMonths(3)->format('Y-m-t 23:59:59')}' ";
		}
		$query .= " GROUP BY ju.id) bl";
		$query .= " GROUP BY bl.tahun, bl.bulan;";

		return $query;
	}
	public function tunggakan($year){

		$mulai = Carbon::now()->subMonths(4)->endOfMonth()->format('Y-m-d');

		$query  = "SELECT ";
		$query .= "nama, ";
		$query .= "asuransi_id, ";
		$query .= "sum(piutang) as piutang, ";
		$query .= "sum(tunai) as tunai, ";
		$query .= "sum(sudah_dibayar) as sudah_dibayar, ";
		$query .= "sum( ";
		$query .= "CASE ";
		$query .= "WHEN tanggal <= '$mulai' ";
		$query .= "THEN piutang - sudah_dibayar ";
		$query .= "ELSE 0 ";
		$query .= "END ";
		$query .= ") as overdue, ";
		$query .= "sum(piutang) - sum(sudah_dibayar) as sisa_piutang ";
		$query .= "FROM ";
		$query .= "(";
		$query .= "SELECT ";
		$query .= "asu.nama as nama, ";
		$query .= "asu.id as asuransi_id, ";
		$query .= "prx.tunai as tunai, ";
		$query .= "prx.tanggal as tanggal, ";
		$query .= "prx.piutang as piutang, ";
		$query .= "COALESCE(sum(pdb.pembayaran),0) as sudah_dibayar ";
		$query .= "FROM periksas as prx ";
		$query .= "LEFT JOIN piutang_dibayars as pdb on prx.id = pdb.periksa_id ";
		$query .= "JOIN asuransis as asu on asu.id = prx.asuransi_id ";
		$query .= "WHERE prx.tanggal like '{$year}%' ";
		$query .= "AND asuransi_id > 0 ";
		$query .= "AND prx.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "GROUP BY prx.id ";
		$query .= ") bl ";
		$query .= "GROUP BY asuransi_id ";
		$query .= "having sisa_piutang > 0 ";
		$query .= "ORDER BY overdue desc";
		$data = DB::select($query);

		$total_tunai         = 0;
		$total_piutang       = 0;
		$total_sudah_dibayar = 0;
		$total_sisa_piutang  = 0;

		foreach ($data as $d) {
			$total_tunai         += $d->tunai;
			$total_piutang       += $d->piutang;
			$total_sudah_dibayar += $d->sudah_dibayar;
			$total_sisa_piutang  += $d->sisa_piutang;
		}

		return view('asuransis.tunggakan_asuransi', compact(
			'year',
			'total_tunai',
			'total_piutang',
			'total_sudah_dibayar',
			'total_sisa_piutang',
			'data'
		));
	}
	public function cekSalahBayar(){
		$query  = "select pmb.id, ";
		$query .= "rke.tanggal as tanggal_dibayar, ";
		$query .= "rke.nilai, ";
		$query .= "pmb.pembayaran, ";
		$query .= "asu.nama as nama_asuransi ";
		$query .= "from pembayaran_asuransis as pmb ";
		$query .= "join rekenings as rke on pmb.id = rke.pembayaran_asuransi_id ";
		$query .= " join asuransis as asu on asu.id = pmb.asuransi_id ";
		$query .= "where staf_id = '180411001' ";
		$query .= "AND pmb.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and rke.nilai not like pmb.pembayaran ";
		$pembayarans = DB::select($query);
		return view('asuransis.cek_salah_bayar', compact(
			'pembayarans'
		));
	}
	public function getAsuransiCoaId(){
		$asuransi_id = Input::get('asuransi_id');
		$asuransi    = Asuransi::find($asuransi_id);
		return $asuransi->coa_id;
	}
	public function riwayatPembayaran($asuransi_id){
		$pembayaran_asuransi_id = Input::get('pembayaran_asuransi_id');
		$tanggal                = Input::get('tanggal');
		$displayed_rows         = Input::get('displayed_rows');
		$pembayaran             = Input::get('pembayaran');
		$nilai                  = Input::get('nilai');
		$key                    = Input::get('key');
		$selisih                = Input::get('selisih');
		$deskripsi              = Input::get('deskripsi_rekening');
		$column_name            = Input::get('column_name');
		$order                  = Input::get('order');

		if ($order == 'no') {
			$order = 'desc';
		} else if ( $order == 'asc' ) {
			$order = 'desc';
		} else if ( $order == 'desc' ) {
			$order = 'asc';
		}

		$pass = $key * $displayed_rows;

		$query  = "SELECT ";
		$query .= "pem.id as pembayaran_asuransi_id, ";
		$query .= "pem.tanggal_dibayar as tanggal_dibayar, ";
		$query .= "pem.pembayaran as pembayaran, ";
		$query .= "rek.nilai - pem.pembayaran as selisih, ";
		$query .= "rek.nilai as nilai, ";
		$query .= "rek.deskripsi as deskripsi ";
		$query .= "FROM pembayaran_asuransis as pem ";
		$query .= "LEFT JOIN rekenings as rek on rek.pembayaran_asuransi_id = pem.id ";
		$query .= "WHERE pem.id like '%{$pembayaran_asuransi_id}%'";
		$query .= "AND ( pem.tanggal_dibayar like '{$tanggal}%' or '{$tanggal}' = '' ) ";
		$query .= "AND ( pem.pembayaran like '{$pembayaran}%' or '{$pembayaran}' = '' ) ";
		$query .= "AND ( rek.nilai like '{$nilai}%' or '{$pembayaran}' = '' ) ";
		$query .= "AND ( rek.deskripsi like '{$deskripsi}%' or '{$deskripsi}' = '' ) ";
		$query .= "AND pem.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "AND pem.asuransi_id like '{$asuransi_id}' ";
		$query .= "ORDER BY {$column_name} {$order} ";

		$data = DB::select($query);
		$total_rows = count($data);

		$query .= "LIMIT {$pass}, {$displayed_rows} ";
		$result = DB::select($query);

		return [
			'data'       => $result,
			'total_rows' => $total_rows
		];
	}
	public function riwayatHutangByParameterGroupedBulanan(){
		$result = $this->riwayatHutangByParameterGroupedQuery();
		return [
			'result'     => $result['result'],
			'total_rows' => $result['total_rows']
		];
		
	}

	public function riwayatHutangByParameterGrouped(){
		$result = $this->riwayatHutangByParameterGroupedQuery(true);
		return [
			'result'     => $result['result'],
			'total_rows' => $result['total_rows']
		];
	}
	public function riwayatHutangByParameterGroupedQuery($duaMingguan = false){
		/* dd( */ 
		/* 	'DUAAAA', */
		/* 	'$this->input_piutang', */
		/* 	$this->input_piutang, */
		/* 	'$this->input_bulan', */
		/* 	$this->input_bulan, */
		/* 	'$this->input_asuransi_id', */
		/* 	$this->input_asuransi_id, */
		/* 	'$this->input_key', */
		/* 	$this->input_key, */
		/* 	'$this->input_sudah_dibayar', */
		/* 	$this->input_sudah_dibayar, */
		/* 	'$this->input_sisa', */
		/* 	$this->input_sisa, */
		/* 	'$this->input_column_order', */
		/* 	$this->input_column_order, */
		/* 	'$this->input_displayed_rows', */
		/* 	$this->input_displayed_rows, */
		/* 	'$this->input_order', */
		/* 	$this->input_order */
		/* ); */
		if ( $this->input_order == 'no' ) {
			$this->input_order = 'asc';
		}
		$pass          = $this->input_key * $this->input_displayed_rows;
		$query  ="select ";
		$query .="bulan, ";
		$query .="sum(piutang) as piutang, ";
		$query .="sum(sudah_dibayar) as sudah_dibayar, ";
		$query .="sum(piutang) - sum(sudah_dibayar) as sisa ";
		$query .="FROM (";
		$query .="select ";
		if ($duaMingguan) {
			$query .="case ";
			$query .="when DATE_FORMAT(px.tanggal, '%d') >= 1 and DATE_FORMAT(px.tanggal, '%d') <= 15 then concat(DATE_FORMAT(px.tanggal, '%Y-%m'), '-01')";
			$query .="else concat(DATE_FORMAT(px.tanggal, '%Y-%m'), '-16') ";
			$query .="end ";
		}else {
			$query .="DATE_FORMAT(px.tanggal, '%Y-%m') ";
		}
		$query .="as bulan, ";
		$query .="px.piutang as piutang, ";
		$query .="COALESCE(sum(pd.pembayaran),0) as sudah_dibayar ";
		$query .="from periksas as px ";
		$query .="LEFT JOIN piutang_dibayars as pd on pd.periksa_id = px.id ";
		$query .="where px.asuransi_id = '{$this->input_asuransi_id}' ";
		$query .= "AND px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .="group by px.id ";
		$query .=") bl ";
		$query .="group by bulan ";
		$query .="having (piutang like '{$this->input_piutang}%' or '{$this->input_piutang}' = '') ";
		$query .="and (sudah_dibayar like '{$this->input_sudah_dibayar}%' or '{$this->input_sudah_dibayar}' = '') ";
		$query .="and (bulan like '{$this->input_bulan}%' or '{$this->input_bulan}' = '') ";
		$query .="and (sisa like '{$this->input_sisa}%' or '{$this->input_sisa}' = '') ";
		$query .="order by {$this->input_column_order} {$this->input_order} ";

		$total_rows = count(DB::select($query));
		$query .= "LIMIT {$pass}, $this->input_displayed_rows ";
		$result = DB::select($query);

		/* dd( $query ); */
		return [
			'total_rows' => $total_rows,
			'result'     => $result
		];
	}
    /**
     * undocumented function
     *
     * @return void
     */
}
