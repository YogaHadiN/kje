<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;
use App\Http\Controllers\LaporanLabaRugisController;
use App\Models\BelanjaPeralatan;
use App\Models\BahanBangunan;
use DB;
use Input;

class PajaksController extends Controller
{

	public function __construct()
	 {
		 $this->middleware('super', ['except' => []]);
	 }
	public function amortisasi(){
		$query  = "select year(created_at) as tahun ";
		$query .= "from penyusutans ";
		$query .= "WHERE tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "group by YEAR(created_at)";
		$data = DB::select($query);

		$lists = [];

		foreach ($data as $d) {
			$year = $d->tahun;
			$lists[$d->tahun] = $d->tahun;
		}
		return view('pajaks.amortisasi', compact(
			'lists'
		));
		
	}
	
	public function amortisasiPost(){
		$tahun           = Input::get('tahun');
		$input_hartas    = $this->queryAmortisasi2( 'harta', 'input_hartas', 'App\\\models\\\InputHarta', 'bp.tanggal_beli', $tahun);
		$bahan_bangunans = $this->queryAmortisasi2( 'keterangan', 'bahan_bangunans', 'App\\\Models\\\BahanBangunan', 'bp.tanggal_renovasi_selesai', $tahun);
		$peralatans      = $this->queryAmortisasi2( 'peralatan', 'belanja_peralatans', 'App\\\Models\\\BelanjaPeralatan', 'fb.tanggal', $tahun);

		$datas = [];
		foreach ($peralatans as $alat) {
			$datas[] = $alat;
		}
		foreach ($input_hartas as $alat) {
			$datas[] = $alat;
		}
		foreach ($bahan_bangunans as $alat) {
			$datas[] = $alat;
		}

		/* $input_hartas    = $this->queryAmortisasi( 'harta', 'input_hartas', 'App\\\InputHarta', 'bp.tanggal_beli', $tahun); */
		/* $bahan_bangunans = $this->queryAmortisasi( 'keterangan', 'bahan_bangunans', 'App\\\BahanBangunan', 'bp.tanggal_renovasi_selesai', $tahun); */
		/* $peralatans      = $this->queryAmortisasi( 'peralatan', 'belanja_peralatans', 'App\\\BelanjaPeralatan', 'fb.tanggal', $tahun); */

		$datas = compact(
			'datas',
			'tahun'
		);

		return view('pajaks.amortisasiPost', $datas);
	}
	private function amortisasiArray($datas){
		$peralatans = [];
		foreach ($datas as $d) {
			$peralatans[ $d->susutable_id ]['susutable_id'] = $d->susutable_id;
			$peralatans[ $d->susutable_id ]['tanggal_perolehan'] = $d->tanggal;
			$peralatans[ $d->susutable_id ]['harga_perolehan'] = $d->harga_satuan * $d->jumlah;
			$peralatans[ $d->susutable_id ]['peralatan'] = $d->peralatan;
			if (
				!isset($peralatans[ $d->susutable_id ]['penyusutan_2_sebelumnya']) 
			) {
				$peralatans[ $d->susutable_id ]['penyusutan_2_sebelumnya'] = 0;
			} 
			if (date('Y',strtotime($d->tanggal_penyusutan)) < ( date('Y') -1 )) {
				$peralatans[ $d->susutable_id ]['penyusutan_2_sebelumnya'] += $d->nilai;
			}
			if (
				!isset($peralatans[ $d->susutable_id ]['total_penyusutan'])
			) {
				$peralatans[ $d->susutable_id ]['total_penyusutan'] = 0;
			} 
			$peralatans[ $d->susutable_id ]['total_penyusutan'] += $d->nilai;
		}
		return $peralatans;
	}
	public function queryAmortisasi(
		$peralatan,
		$belanja_peralatans,
		$BelanjaPeralatan,
		$tanggal,
		$tahun
	){
		$tahun_pajak = $tahun +1;
		$first_date_of_the_year          = date($tahun_pajak .'-01-01');//2017-01-01 00:00:00
		$first_date_of_the_previous_year = date('Y-m-d H:i:s', strtotime("-1 year " . $first_date_of_the_year)); //2016-01-01 00:00:00

		$query  = "SELECT ";
		$query .= "bp.{$peralatan} as peralatan, ";
		/* $query .= "DATE_FORMAT({$tanggal}, '%M %Y') as tanggal_perolehan, "; */
		$query .= "SUM(CASE WHEN pn.created_at < '{$first_date_of_the_previous_year}' THEN pn.nilai ELSE 0 END) AS susut_fiskal_tahun_lalu,";
		$query .= "SUM(nilai) AS total_penyusutan, ";
		if ($BelanjaPeralatan != 'App\\\Models\\\BahanBangunan') {
			$query .= "bp.masa_pakai as masa_pakai, ";
		}
		if ($BelanjaPeralatan == 'App\\\Models\\\BahanBangunan') {
			$query .= "bp.bangunan_permanen as permanen, ";
		}
		if ( $BelanjaPeralatan == 'App\\\Models\\\InputHarta' ) {
			$query .= "bp.harga as harga_satuan, ";
			$query .= "1 as jumlah, ";
			$query .= "bp.tanggal_beli as tanggal, ";
		} else {
			$query .= "bp.harga_satuan as harga_satuan, ";
			$query .= "bp.jumlah as jumlah, ";
			$query .= "fb.tanggal as tanggal, ";
		}
		$query .= "pn.created_at as tanggal_penyusutan ";
		$query .= "FROM penyusutans as pn ";
		$query .= "left JOIN {$belanja_peralatans} as bp on bp.id = pn.susutable_id ";
		if ( $BelanjaPeralatan != 'App\\\Models\\\InputHarta' ) {
			$query .= "left JOIN faktur_belanjas as fb on fb.id = bp.faktur_belanja_id ";
		}
		$query .= "WHERE pn.created_at < '{$first_date_of_the_year}'";
		$query .= "AND pn.susutable_type = '{$BelanjaPeralatan}' ";
		$query .= "AND pn.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "GROUP BY pn.susutable_id";

		//return $query;
		return DB::select($query);
	}

	public function queryAmortisasi2(
		$peralatan,
		$belanja_peralatans,
		$BelanjaPeralatan,
		$tanggal,
		$tahun
	){
		$tahun_pajak = $tahun +1;
		$first_date_of_the_year          = date($tahun_pajak .'-01-01');//2017-01-01 00:00:00
		$first_date_of_the_previous_year = date('Y-m-d H:i:s', strtotime("-1 year " . $first_date_of_the_year)); //2016-01-01 00:00:00

		$query  = "SELECT ";
		$query .= 'bp.id as id, ';
		if ($BelanjaPeralatan != 'App\\\Models\\\BahanBangunan') {
			$query .= '"1" as jenis_harta, ';
		}
		if ($BelanjaPeralatan == 'App\\\Models\\\BahanBangunan') {
			$query .= '"2" as jenis_harta, ';
		}
		$query .= '(CASE ';
		if ($BelanjaPeralatan != 'App\\\Models\\\BahanBangunan') {
			$query .= '    WHEN bp.masa_pakai = "4" THEN 1 ';
			$query .= '    WHEN bp.masa_pakai = "8" THEN 2 ';
			$query .= '    WHEN bp.masa_pakai = "16" THEN 3 ';
			$query .= '    WHEN bp.masa_pakai = "20" THEN 4 ';
		}
		if ($BelanjaPeralatan == 'App\\\Models\\\BahanBangunan') {
			$query .= '    WHEN bp.bangunan_permanen = "1" THEN 5 ';
			$query .= '    WHEN bp.bangunan_permanen = "0" THEN 6 ';
		}
		$query .= 'END) AS kelompok_harta,';
		$query .= '"111" as jenis_usaha, ';
		$query .= "bp.{$peralatan} as nama_harta, ";
		$query .= "DATE_FORMAT({$tanggal}, '%c') as bulan_perolehan, ";
		$query .= "DATE_FORMAT({$tanggal}, '%Y') as tahun_perolehan, ";
		/* $query .= "DATE_FORMAT({$tanggal}, '%Y-%c-%d') as tanggal_perolehan, "; */
		$query .= '"1" as jenis_penyusutan_komersial, ';
		$query .= '"1" as jenis_penyusutan_fiskal, ';
		if ( $BelanjaPeralatan == 'App\\\Models\\\InputHarta' ) {
			$query .= 'bp.harga as harga_perolehan, ';
		} else {
			$query .= "bp.harga_satuan * bp.jumlah as harga_perolehan, ";
		}
		if ( $BelanjaPeralatan == 'App\\\Models\\\InputHarta' ) {
			$query .= 'bp.harga - SUM(CASE WHEN pn.created_at < "2020-01-01 00:00:00" THEN pn.nilai ELSE 0 END) AS nilai_sisa_buku,';
		} else {
			$query .= 'bp.harga_satuan * bp.jumlah - SUM(CASE WHEN pn.created_at < "2020-01-01 00:00:00" THEN pn.nilai ELSE 0 END) AS nilai_sisa_buku,';
		}
		$query .= 'SUM(pn.nilai) - SUM(CASE WHEN pn.created_at < "2020-01-01 00:00:00" THEN pn.nilai ELSE 0 END) AS penyusutan_fiskal_tahun_ini, ';
		$query .= '"-" as keterangan_nama_harta ';
		$query .= "FROM penyusutans as pn ";
		$query .= "left JOIN {$belanja_peralatans} as bp on bp.id = pn.susutable_id ";
		if ( $BelanjaPeralatan != 'App\\\Models\\\InputHarta' ) {
			$query .= "left JOIN faktur_belanjas as fb on fb.id = bp.faktur_belanja_id ";
		}
		$query .= "WHERE pn.created_at < '{$first_date_of_the_year}'";
		$query .= "AND pn.susutable_type = '{$BelanjaPeralatan}' ";
		$query .= "AND pn.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "GROUP BY pn.susutable_id";

		return DB::select($query);
	}


	public function peredaranBrutoPost(){
		$tahun = Input::get('tahun');
		$peredaranBruto = $this->queryPeredaranBruto($tahun);
		return view('pajaks.peredaranBrutoPost', compact(
			'peredaranBruto', 'tahun'
		));
	}
	public function peredaranBruto(){
		$pluck = $this->pluckTahun();
		$bikinan = false;
		return view('pajaks.peredaranBruto', compact(
			'bikinan',
			'pluck'
		));
	}
	
	public function queryPeredaranBruto($tahun, $bikinan = false){
		$llr   = new LaporanLabaRugisController;
		$akuns = $llr->queryLaporanKeuangan($tahun, null, null);

		$perbulan = [];
		$data_pendapatan_lain = [];
		foreach ($akuns as $akun) {
			if ( 
				substr($akun->coa_id, 0, 1) == '4' ||
				substr($akun->coa_id, 0, 1) == '7'
			) {
				if ( 
					$bikinan 
					&& $akun->jurnalable_type == 'App\Models\Periksa' 
					&& $akun->asuransi_id == '0'
				) {
					unset($akun);
					continue;
				}

				$month = Carbon::parse($akun->created_at)->format('F');
				if ( !isset($perbulan[ $month ]['nilai_debit']) ) {
					$perbulan[ $month ]['nilai_debit']   = 0;
				}
				if ( !isset($perbulan[ $month ]['nilai_kredit']) ) {
					$perbulan[ $month ]['nilai_kredit']  = 0;
				}

				if ( $akun->debit                                         == 1 ) {
					$perbulan[ $month ]['nilai_debit']          += $akun->nilai; // get nilai debit
				} else {
					$perbulan[ $month ]['nilai_kredit']         += $akun->nilai; // get nilai kredit
				}
			}
		}

		$akuns = [];
        $coa_id_70100 = Coa::where('kode_coa', '70100')->first()->id;
		foreach ($perbulan as $k => $pb) {
			/* dd( $pb ); */
			if ($akun->coa_id == $coa_id_70100) {
				$data_pendapatan_lain[] = $akun;
			}
			$akuns[] = [
				'bulan' => $k,
				'nilai' => abs($pb['nilai_debit'] - $pb['nilai_kredit'])
			];
		}
		/* dd( $data_pendapatan_lain ); */

		return $akuns;

	}
	public function peredaranBrutoBikinan(){
		$pluck   = $this->pluckTahun();
		$bikinan = true;
		return view('pajaks.peredaranBruto', compact(
			'bikinan',
			'pluck',
		));
	}

	public function peredaranBrutoBikinanPost(){
		$tahun          = Input::get('tahun');
		$peredaranBruto = $this->queryPeredaranBruto($tahun, true);

		$total = 0;
		foreach ($peredaranBruto as $v) {
			$total += $v['nilai'];
		}

		return view('pajaks.peredaranBrutoPost', compact(
			'peredaranBruto', 'tahun', 'total'
		));
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function pluckTahun()
	{
		$query  = "select year(created_at) as tahun ";
		$query .= "from jurnal_umums ";
		$query .= "WHERE tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "group by YEAR(created_at)";
		$data = DB::select($query);

		$pluck = [];

		foreach ($data as $d) {
			$year = $d->tahun;
			$pluck[$d->tahun] = $d->tahun;
		}
		return $pluck;
	}
	
	
}
