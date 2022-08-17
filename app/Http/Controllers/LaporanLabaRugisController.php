<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\JurnalUmumsController;
use App\Models\Classes\Yoga;
use App\Models\JurnalUmum;
use Input;
use DB;

class LaporanLabaRugisController extends Controller
{

  public function __construct()
    {
        $this->middleware('super', ['except' => []]);
        $this->middleware('notready', ['only' => ['perBulan']]);
    }
    public function index(){
		$range   = $this->rangeLabaRugi();
		$bulan   = $range['bulan'];
		$tahun   = $range['tahun'];
		$bikinan = false;

		return view('laporan_laba_rugis.index',compact(
			'tahun',
			'bikinan',
			'bulan'
		));
    }
    public function bikinan(){
		$range   = $this->rangeLabaRugi();
		$bulan   = $range['bulan'];
		$tahun   = $range['tahun'];
		$bikinan = true;

    	return view('laporan_laba_rugis.index',compact(
			'tahun',
			'bikinan',
			'bulan'
		));
    }


	public function bikinanShow(){

		$bulan_awal  = Input::get('bulan_awal');
		$bulan_akhir = Input::get('bulan_akhir');
		$tahun_awal  = Input::get('tahun_awal');
		$tahun_akhir = Input::get('tahun_akhir');

		$tanggal_awal  = $tahun_awal. "-" . str_pad($bulan_awal, 2, '0', STR_PAD_LEFT)  . "-01"  ;
		$tanggal_akhir = $tahun_akhir. "-" . str_pad($bulan_akhir, 2, '0', STR_PAD_LEFT) . "-01"  ;
		$tanggal_akhir = date("Y-m-t", strtotime($tanggal_akhir));

		$tempLaporanLabaRugi = $this->tempLaporanLabaRugiRangeByDate($tanggal_awal, $tanggal_akhir, true);
		/* dd($tempLaporanLabaRugi); */

		$pendapatan_usahas   = $tempLaporanLabaRugi['pendapatan_usahas'];
		$hpps                = $tempLaporanLabaRugi['hpps'];
		$biayas              = $tempLaporanLabaRugi['biayas'];
		$pendapatan_lains    = $tempLaporanLabaRugi['pendapatan_lains'];
		$bulan               = $tempLaporanLabaRugi['bulan'];
		$tahun               = $tempLaporanLabaRugi['tahun'];
		$bebans              = $tempLaporanLabaRugi['bebans'];
		$bikinan             = true;

    	return view('laporan_laba_rugis.show', compact(
            'pendapatan_usahas',
            'bikinan',
            'hpps',
            'tanggal_awal',
            'tanggal_akhir',
            'biayas',
            'pendapatan_lains',
            'bulan',
            'tahun',
            'bebans'
        ));

	}

	public function show(){
		$bulan_awal  = Input::get('bulan_awal');
		$bulan_akhir = Input::get('bulan_akhir');
		$tahun_awal  = Input::get('tahun_awal');
		$tahun_akhir = Input::get('tahun_akhir');

		$tanggal_awal  = $tahun_awal. "-" . str_pad($bulan_awal, 2, '0', STR_PAD_LEFT)  . "-01"  ;
		$tanggal_akhir = $tahun_akhir. "-" . str_pad($bulan_akhir, 2, '0', STR_PAD_LEFT) . "-01"  ;
		$tanggal_akhir = date("Y-m-t", strtotime($tanggal_akhir));

		$tempLaporanLabaRugi = $this->tempLaporanLabaRugiRangeByDate($tanggal_awal, $tanggal_akhir);

		$pendapatan_usahas   = $tempLaporanLabaRugi['pendapatan_usahas'];
		$hpps                = $tempLaporanLabaRugi['hpps'];
		$biayas              = $tempLaporanLabaRugi['biayas'];
		$pendapatan_lains    = $tempLaporanLabaRugi['pendapatan_lains'];
		$bulan               = $tempLaporanLabaRugi['bulan'];
		$tahun               = $tempLaporanLabaRugi['tahun'];
		$bebans              = $tempLaporanLabaRugi['bebans'];
		$bikinan = false;

    	return view('laporan_laba_rugis.show', compact(
            'pendapatan_usahas',
            'hpps',
            'bikinan',
            'tanggal_awal',
            'tanggal_akhir',
            'biayas',
            'pendapatan_lains',
            'bulan',
            'tahun',
            'bebans'
        ));
	}

    public function perBulanBikinan($bulan, $tahun){

		$templaporanlabarugibikinan = $this->templaporanlabarugibikinan($bulan, $tahun, 'perBulan');
		$pendapatan_usahas = $templaporanlabarugibikinan['pendapatan_usahas'];
		$hpps              = $templaporanlabarugibikinan['hpps'];
		$biayas            = $templaporanlabarugibikinan['biayas'];
		$pendapatan_lains  = $templaporanlabarugibikinan['pendapatan_lains'];
		$bulan             = $templaporanlabarugibikinan['bulan'];
		$tahun             = $templaporanlabarugibikinan['tahun'];
		$bebans            = $templaporanlabarugibikinan['bebans'];
		//return $pendapatan_usahas['akuns'];
    	return view('laporan_laba_rugis.show', compact(
            'pendapatan_usahas',
            'hpps',
            'biayas',
            'pendapatan_lains',
            'bulan',
            'tahun',
            'bebans'
        ));
    }
	public function perTahunBikinan($tahun){
		$path = Input::path();
		/* $jn = new JurnalUmumsController; */
		/* $ju->notReady($path); */
		$templaporanlabarugibikinan = $this->tempLaporanLabaRugiRangeByDate(null, $tahun, 'perTahun', true);
		$pendapatan_usahas = $templaporanlabarugibikinan['pendapatan_usahas'];
		$hpps              = $templaporanlabarugibikinan['hpps'];
		$biayas            = $templaporanlabarugibikinan['biayas'];
		$pendapatan_lains  = $templaporanlabarugibikinan['pendapatan_lains'];
		$bulan             = $templaporanlabarugibikinan['bulan'];
		$tahun             = $templaporanlabarugibikinan['tahun'];
		$bebans            = $templaporanlabarugibikinan['bebans'];
		//return $pendapatan_usahas['akuns'];
    	return view('laporan_laba_rugis.show', compact(
            'pendapatan_usahas',
            'hpps',
            'biayas',
            'pendapatan_lains',
            'bulan',
            'tahun',
            'bebans'
        ));
	}
    public function perBulan($bulan, $tahun){
		$per = '/pdfs/laporan_laba_rugi/perBulan/'. $bulan . '/' . $tahun ;
		$tempLaporanLabaRugi = $this->tempLaporanLabaRugi($bulan, $tahun, 'perBulan');
		$pendapatan_usahas   = $tempLaporanLabaRugi['pendapatan_usahas'];
		$hpps                = $tempLaporanLabaRugi['hpps'];
		$biayas              = $tempLaporanLabaRugi['biayas'];
		$pendapatan_lains    = $tempLaporanLabaRugi['pendapatan_lains'];
		$bulan               = $tempLaporanLabaRugi['bulan'];
		$tahun               = $tempLaporanLabaRugi['tahun'];
		$bebans              = $tempLaporanLabaRugi['bebans'];

    	return view('laporan_laba_rugis.show', compact(
            'pendapatan_usahas',
            'hpps',
            'per',
            'biayas',
            'pendapatan_lains',
            'bulan',
            'tahun',
            'bebans'
        ));
    }
	public function perTahun($tahun){
		$path = Input::path();
		$per = '/pdfs/laporan_laba_rugi/perTahun/'. $tahun;
		$tempLaporanLabaRugi = $this->tempLaporanLabaRugi(null, $tahun, 'perTahun');
		$pendapatan_usahas = $tempLaporanLabaRugi['pendapatan_usahas'];
		$hpps              = $tempLaporanLabaRugi['hpps'];
		$biayas            = $tempLaporanLabaRugi['biayas'];
		$pendapatan_lains  = $tempLaporanLabaRugi['pendapatan_lains'];
		$bulan             = $tempLaporanLabaRugi['bulan'];
		$tahun             = $tempLaporanLabaRugi['tahun'];
		$bebans            = $tempLaporanLabaRugi['bebans'];
		//return $pendapatan_usahas['akuns'];
    	return view('laporan_laba_rugis.show', compact(
            'pendapatan_usahas',
            'hpps',
            'per',
            'biayas',
            'pendapatan_lains',
            'bulan',
            'tahun',
            'bebans'
        ));
	}
	public function tempLaporanLabaRugi($bulan, $tahun, $periode){
		$query              = "select ";
		$query             .= "coa_id as coa_id, ";
		$query             .= "c.coa as coa, ";
		$query             .= "abs( sum( if ( debit = 1, nilai, 0 ) ) - sum( if ( debit = 0, nilai, 0 ) ) ) as nilai ";
		$query             .= "from jurnal_umums as j join coas as c on c.id = j.coa_id ";

		if ($periode       == 'perBulan') {
			$query         .= "where j.created_at like '{$tahun}-{$bulan}%' ";
		}else if( $periode == 'perTahun' ) {
			$query         .= "where j.created_at like '{$tahun}%' ";
		}

		$query             .= "and ( c.kelompok_coa_id between 4 and 8 ) ";
		$query             .= "AND j.tenant_id = " . session()->get('tenant_id') . " ";
		$query             .= "group by coa_id ";

        $akuns              = DB::select($query);

		return $this->olahDataLaporanLabaRugi($akuns, $bulan, $tahun);
	}
	public function tempLaporanLabaRugiRangeByDate($tanggal_awal, $tanggal_akhir, $bikinan = false){

		$akuns = $this->queryLaporanKeuangan(false, $tanggal_awal, $tanggal_akhir);
		/* dd($akuns); */
		$dataGrouped = [];
		foreach ($akuns as $k => $akun) {
			 /* kalau bikinan exclude semua asuransi_id dengan nilai 0 dan jurnalable_type = periksa */
			if ( 
				$bikinan 
				&& $akun->jurnalable_type == 'App\Models\Periksa' 
				&& $akun->asuransi_id == '0'
			) {
				unset($akun);
				continue;
			}

			$dataGrouped[ $akun->coa_id ]['coa_id']            = $akun->coa_id; // get coa_id
			$dataGrouped[ $akun->coa_id ]['coa']               = $akun->coa; // get coa

			if ( !isset($dataGrouped[ $akun->coa_id ]['nilai_debit']) ) {
				$dataGrouped[ $akun->coa_id ]['nilai_debit']   = 0;
			}

			if ( !isset($dataGrouped[ $akun->coa_id ]['nilai_kredit']) ) {
				$dataGrouped[ $akun->coa_id ]['nilai_kredit']  = 0;
			}

			if ( $akun->debit                                 == 1 ) {
				$dataGrouped[ $akun->coa_id ]['nilai_debit']  += $akun->nilai; // get nilai debit
			} else {
				$dataGrouped[ $akun->coa_id ]['nilai_kredit'] += $akun->nilai; // get nilai kredit
			}
		}
		$akuns=[];
		foreach ($dataGrouped as $data) {
			$akuns[] = [
				'coa_id' => $data['coa_id'],
				'coa'    => $data['coa'],
				'nilai'  => abs($data['nilai_debit'] - $data['nilai_kredit'])
			];
		}


		return $this->olahDataLaporanLabaRugi($akuns, null, null, $tanggal_awal, $tanggal_akhir);
	}

	public function templaporanlabarugibikinan($tanggal_awal, $tanggal_akhir){
		$query  = "select ";
		$query .= "coa_id as coa_id, ";
		$query .= "c.kode_coa as kode_coa, ";
		$query .= "c.coa as coa, ";
        if ( env("DB_ENVIRONMENT") == 'mysql' ) {
            $query .= "abs( sum( if ( debit = 1, nilai, 0 ) ) - sum( if ( debit = 0, nilai, 0 ) ) ) as nilai ";
        } else {
            $query .= "abs( sum( iif ( debit = 1, nilai, 0 ) ) - sum( iif ( debit = 0, nilai, 0 ) ) ) as nilai ";
        }
        $query .= "from jurnal_umums as j ";
        $query .= "join coas as c on c.id = j.coa_id ";
		$query .= "left join periksas as px on px.id = j.jurnalable_id ";
		$query .= "where date(j.created_at) between '{$tanggal_awal} 00:00:00' and '{$tanggal_akhir} 23:59:59'  ";
		$query .= "and ( c.kelompok_coa_id between 4 and 8 ) ";
		$query .= "AND j.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "group by coa_id ";
        $akuns  = db::select($query);
		/* dd($query); */


		return $this->olahDataLaporanLabaRugi($akuns, null, null, $tanggal_awal, $tanggal_akhir);
	}
	private function olahDataLaporanLabaRugi($akuns, $bulan, $tahun, $tanggal_awal = null, $tanggal_akhir = null){

		$pendapatan_usahas['akuns'] = [];
		$hpps['akuns']              = [];
		$pendapatan_usahas['akuns'] = [];
		$hpps['akuns']              = [];
		$biayas['akuns']            = [];
		$pendapatan_lains['akuns']  = [];
		$bebans['akuns']            = [];

		$pendapatan_usahas['total_nilai'] = 0;
		$hpps['total_nilai']              = 0;
		$pendapatan_usahas['total_nilai'] = 0;
		$hpps['total_nilai']              = 0;
		$biayas['total_nilai']            = 0;
		$pendapatan_lains['total_nilai']  = 0;
		$bebans['total_nilai']            = 0;
		foreach ($akuns as $a) {
			if (substr($a['kode_coa'], 0, 1) === '4') {
				$pendapatan_usahas['akuns'][] = $a;
				$pendapatan_usahas['total_nilai'] += $a['nilai'];
			} else if( substr($a['kode_coa'], 0, 1) === '5' ){
				$hpps['akuns'][] = $a;
				$hpps['total_nilai'] += $a['nilai'];
			} else if( substr($a['kode_coa'], 0, 1) === '6' ){
				$biayas['akuns'][] = $a;
				$biayas['total_nilai'] += $a['nilai'];
			} else if( substr($a['kode_coa'], 0, 1) === '7' ){
				$pendapatan_lains['akuns'][] = $a;
				$pendapatan_lains['total_nilai'] += $a['nilai'];
			} else if( substr($a['kode_coa'], 0, 1) === '8' ){
				$bebans['akuns'][] = $a;
				$bebans['total_nilai'] += $a['nilai'];
			}
		}
		return [
            'pendapatan_usahas' => $pendapatan_usahas,
            'hpps'              => $hpps,
            'biayas'            => $biayas,
            'pendapatan_lains'  => $pendapatan_lains,
            'bulan'             => $bulan,
            'tahun'             => $tahun,
            'tanggal_awal'      => $tanggal_awal,
            'tanggal_akhir'     => $tanggal_akhir,
            'bebans'            => $bebans
		];
	}
	public function rangeLabaRugi(){
		
		$query  = "SELECT year(created_at) as tahun ";
		$query .= "FROM jurnal_umums ";
		$query .= "WHERE tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "GROUP BY year(created_at) ";
		$data   = DB::select($query);

		$tahun=[];
		foreach ($data as $d) {
			$tahun[$d->tahun] = $d->tahun;
		}

		$data_bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

		$bulan = [];

		foreach ($data_bulan as $k => $b) {
			$bulan[$k +1] = $b;
		}

		return compact('bulan', 'tahun');
	}
	public function queryLaporanKeuangan($tahun, $tanggal_awal, $tanggal_akhir){
		$query  = "select ";
		$query .= "px.asuransi_id as asuransi_id, ";
		$query .= "j.jurnalable_type as jurnalable_type, ";
		$query .= "coa_id as coa_id, ";
		$query .= "co.kode_coa as kode_coa, ";
		$query .= "co.kelompok_coa_id as kelompok_coa_id, ";
		$query .= "debit as debit, ";
		$query .= "c.coa as coa, ";
		$query .= "j.created_at as created_at, ";
		$query .= "j.nilai as nilai ";
		$query .= "from jurnal_umums as j join coas as c on c.id = j.coa_id ";
		$query .= "JOIN coas as co on co.id = j.coa_id ";
		$query .= "left join periksas as px on px.id = j.jurnalable_id ";
		if ( $tahun ) {
			$query .= "WHERE j.created_at like '{$tahun}%' ";
		} else {
			$query .= "WHERE j.created_at between '{$tanggal_awal} 00:00:00' and '{$tanggal_akhir} 23:59:59'";
		}
		$query .= "and ( co.kelompok_coa_id between 4 and 8 ) ";
		$query .= "AND j.tenant_id = " . session()->get('tenant_id') . " ";
		/* $query .= "group by coa_id "; */
        return DB::select($query);
	}
	
	
}
