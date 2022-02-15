<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use DateTime;
use Exception;
use Carbon\Carbon;
use Artisan;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use App\Models\Rekening;
use App\Models\Asuransi;
use App\Models\PiutangDibayar;
use App\Models\AbaikanTransaksi;
use App\Models\Classes\Yoga;
use App\Imports\PembayaranImport;

class RekeningController extends Controller
{

	private $input_tanggal;
	private $input_displayed_rows;
	private $input_key;
	private $input_deskripsi;
	private $input_akun_bank_id;
	private $input_pembayaran_null;


   public function __construct()
    {
		$this->input_tanggal         = Input::get('tanggal') .  "%";
		$this->input_displayed_rows  = Input::get('displayed_rows');
		$this->input_key             = Input::get('key');
		$this->input_nilai           = Input::get('nilai') . "%";
		$this->input_deskripsi       = "%" . Input::get('deskripsi') . "%";
		$this->input_akun_bank_id    = Input::get('akun_bank_id');
		$this->input_pembayaran_null = Input::get('pembayaran_null');
        $this->middleware('super', ['only' => ['ignoredList', 'ignore']]);
        $this->middleware('admin', ['except' => []]);
    }
	public function index($id){
		/* try { */
			Artisan::call('cek:mutasi20terakhir');
		/* } catch (\Exception $e) { */
		/* 	$pesan = Yoga::gagalFlash('Mutasi Moota gagal'); */
		/* 	session(['pesan' => $pesan]); */
		/* } */

		$ignored_ids = $this->cariIgnoredIds();
		$rekening    = $this->rekeningCari($id,$ignored_ids);
		/* dd( 'oon', $rekening ); */

		if ( is_null($rekening)) {
			$pesan = Yoga::gagalFlash('Tidak ada data rekening yang bisa diambil');
			return redirect()->back()->withPesan($pesan);
		}

		return view('rekenings.index', compact('rekening', 'ignored_ids'));
	}
	public function search(){
		$data          = $this->queryData( false);
		$count         = $this->queryData( false, true);
		$pages = ceil( $count/ $this->input_displayed_rows );
		return [
			'data'  => $data,
			'pages' => $pages,
			'key'   => $this->input_key,
			'rows'  => $count
		];

	}
	private function queryData(
		$include_abaikan = false,
		$count = false
	){
		$pass                  = $this->input_key * $this->input_displayed_rows;
		$query  = "SELECT ";
		if (!$count) {
			$query .= "str_to_date(tanggal, '%Y-%m-%d') as tanggal, ";
			$query .= "deskripsi, ";
			$query .= "id, ";
			$query .= "pembayaran_asuransi_id, ";
			$query .= "nilai, ";
			$query .= "saldo_akhir ";
		} else {
			$query .= "count(id) as jumlah ";
		}
		$query .= "FROM rekenings ";
		$query .= "WHERE ";
		if (!$include_abaikan) {
			$query .= "akun_bank_id = '{$this->input_akun_bank_id}' AND ";
		}
		$query .= "debet = 0 ";
		$query .= "AND deskripsi not like '%PURI WIDIYANI MARTIADEWI%' ";
		$query .= "AND deskripsi not like '%Bunga Rekening%' ";
		if ( !empty($this->ignoredId()) ) {
			if ( $include_abaikan ) {
				$query .= "AND id in (" . $this->ignoredId() . ") ";
			} else {
				$query .= "AND id not in (" . $this->ignoredId() . ") ";
			}
		}
		if ( $this->input_pembayaran_null == '1' ) {
			$query .= "AND (pembayaran_asuransi_id = '' or pembayaran_asuransi_id is null) ";
		} else if (   $this->input_pembayaran_null == '2' ){
			$query .= "AND (pembayaran_asuransi_id not like '' and pembayaran_asuransi_id is not null) ";
		}
		$query .= "AND ";
		$query .= "(deskripsi like '{$this->input_deskripsi}' and tanggal like '{$this->input_tanggal}') ";
		$query .= "AND ";
		$query .= "(nilai like '{$this->input_nilai}%' or '{$this->input_nilai}' = '') ";
		$query .= "ORDER BY tanggal desc, created_at desc ";
		if (!$count) {
			$query .= "LIMIT {$pass}, {$this->input_displayed_rows};";
		}
		/* dd( $query ); */
		if (!$count) {
			return DB::select($query);
		} else {
			return DB::select($query)[0]->jumlah;
		}
	}
	public function available(){
		$id          = Input::get('id');
		$kata_kunci  = Input::get('kata_kunci');
		$asuransi_id = Input::get('asuransi_id');
		$rekening_available = '0';
		$kata_kunci_valid  = '1';
		try {
			Rekening::findOrFail($id);
			$rekening_available = '1';
		} catch (\Exception $e) {
			$rekening_available = '0';
		}

		try {
			Asuransi::where('id', '!=', $asuransi_id )
				->where('kata_kunci', $kata_kunci)
				->firstOrFail();
			$kata_kunci_valid = '0';
		} catch (\Exception $e) {
			$kata_kunci_valid = '1';
		}

		return compact('rekening_available', 'kata_kunci_valid');
	}
	public function cekId(){
		$id = Input::get('id');
		try {
			return Rekening::findOrFail($id);
		} catch (\Exception $e) {
	
		}
	}
	private function ignoredId(){
		$ignored_ids = '';
		$abaikans = AbaikanTransaksi::all();
		foreach ($abaikans as $k => $abaikan) {
			if ($k == 0) {
				$ignored_ids .= "'" . $abaikan->transaksi_id . "'" ;
			} else {
				$ignored_ids .= ", '" . $abaikan->transaksi_id . "'";
			}
		}
		return $ignored_ids;
	}
	public function ignore($id){

		$abaikan               = new AbaikanTransaksi;
		$abaikan->transaksi_id = $id;
		$abaikan->save();

		$rekening              = Rekening::find( $id );
		$nilai                 = $rekening->nilai;
		$deskripsi             = $rekening->deskripsi;

		$pesan = Yoga::suksesFlash('Transaksi senilai <strong>' . Yoga::buatrp( $nilai ) . '</strong> dengan deskripsi <strong>' . $deskripsi . '</strong> berhasil di abaikan');
		return redirect()->back()->withPesan($pesan);
		
	}
	public function ignoredList(){

		$ignored_ids = $this->cariIgnoredIds();
		$rekening    = $this->rekeningCari(null,$ignored_ids);

		return view('rekenings.abaikan', compact('rekening', 'ignored_ids'));
	}
	public function ignoredListAjax(){
		$data  = $this->queryData( true);
		$count = $this->queryData( true, true);
		$pages = ceil( $count/ $this->input_displayed_rows );
		return [
			'data'  => $data,
			'pages' => $pages,
			'key'   => $this->input_key,
			'rows'  => $count
		];
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function rekeningCari($id, $ignored_ids)
	{
		if ( !is_null($id) ) {
			return Rekening::where('akun_bank_id', $id)
				->where('debet', '0')
				->whereNotIn('id', $ignored_ids)
				->orderBy('tanggal', 'desc')->first();
			
		}
		return Rekening::where('debet', '0')
			->whereIn('id', $ignored_ids)
			->orderBy('tanggal', 'desc')->first();
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function cariIgnoredIds()
	{
		$ignored     = AbaikanTransaksi::all();
		$ignored_ids = [];
		foreach ($ignored as $ignore) {
			$ignored_ids[] = $ignore->transaksi_id;
		}
		return $ignored_ids;
	}
	public function show($rekening_id){
		$rekening         = Rekening::with('pembayaran_asuransi.piutang_dibayar.periksa.pasien')->where('id',$rekening_id )->first();

		$total_tunai         = 0;
		$total_piutang       = 0;
		$total_sudah_dibayar = 0;



		foreach ($rekening->pembayaran_asuransi->piutang_dibayar as $piutang) {
			$total_sudah_dibayar   += $piutang->pembayaran;
			$total_tunai   += $piutang->periksa->tunai;
			$total_piutang += $piutang->periksa->piutang;
		}

		return view('rekenings.show', compact(
			'rekening',
			'total_tunai',
			'total_piutang',
			'total_sudah_dibayar'
		));
	}
	public function unignore($id){
		AbaikanTransaksi::where('transaksi_id', $id)->delete();
		$pesan = Yoga::suksesFlash('transaksi ' . $id . ' Berhasil Diunignore');
		return redirect()->back()->withPesan($pesan);
	}
	public function importCreate(){
		return view('rekenings.createImport');
	}
	public function importPost(){
		$file      = Input::file('transaksi'); //GET FILE
		$excel     = Excel::toArray(new PembayaranImport, $file)[0];
		$timestamp = date('Y-m-d H:i:s');
		$rekenings = [];
		$abaikans  = [];
		$not_inserted = [];
		foreach ($excel as $x) {

			if (isset($x[0])){
				$nilai = (float) $x[4];

				if (!isset($x[6])) {
					if ($nilai > 0) {
						$debet = 0;
					} else {
						$debet = 1;
					}
				} else {
					$debet = $x[6];
				}

				if (DateTime::createFromFormat('Y-m-d', $x[2]) !== FALSE) {
					$tanggal = $x[2];
				} else  if (DateTime::createFromFormat('d-M-Y', $x[2]) !== FALSE) {
					$tanggal = Carbon::createFromFormat('d-M-Y', $x[2])->format('Y-m-d');
				} else {
					throw new Exception("Format tanggal tidak dikenal : " . $x[2]);
				}

				$test_transaksi = Rekening::where('akun_bank_id', 'pG1karGazgM')
						->where('nilai', abs($nilai))
						->where('tanggal', $tanggal)
						->where('debet', $debet)
						->first();
				if (
					is_null($test_transaksi)
				) {
					/* dd( 'exist', $test_transaksi ); */
					$rekenings[] = [
						'id'                     => $x[0],
						'akun_bank_id'           => $x[1],
						'tanggal'                => $tanggal,
						'deskripsi'              => $x[3],
						'nilai'                  => abs($nilai),
						'saldo_akhir'            => $x[5],
						'debet'                  => $debet,
						'pembayaran_asuransi_id' => null,
						'old_id'                 => null,
						'created_at'             => $timestamp,
						'updated_at'             => $timestamp
					];
				} else {
					$not_inserted[] = [
						'nilai'   => abs($nilai),
						'tanggal' => $tanggal
					];
				}
			} 
		}

		$message = 'Berhasil memasukkan ' . count($rekenings). ' data. '  . count($not_inserted). ' gagal dimasukkan : <br /><br />';
		$message .= '<ul>';
		foreach ($not_inserted as $ni) {
			$message .= '<li>' . $ni['tanggal'] . ' sebesar ' . $ni['nilai']. '</li>';
		}
		$message .= '</ul>';
		Rekening::insert($rekenings);
		$pesan = Yoga::suksesFlash($message);
		return redirect()->back()->withPesan($pesan);
	}
}
