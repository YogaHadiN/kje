<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Input;
use PDF;
use DB;
use App\Models\Periksa;
use App\Models\Asuransi;
use App\Models\Classes\Yoga;
use App\Http\Controllers\PdfsController;

class LaporanBpjsController extends Controller
{
	public $bulan;
	public function __construct()
	{
		/* dd(Input::all()); */ 
		
	}
	
	public function hipertensi(){
		return view('laporans.bpjs.hipertensi', [
			'periksas' => $this->queryHipertensi(),
			'bulan'    => Carbon::CreateFromFormat('m-Y',Input::get('bulanTahun'))
		]);
	}
	public function hipertensiPdf(){

		$pdf   = PDF::loadView(
					'laporans.bpjs.hipertensipdf', 
					[
						'periksas' => $this->queryHipertensi(),
						'bulan'    => Carbon::CreateFromFormat('m-Y',Input::get('bulanTahun'))
					])
				->setPaper('a4');
        return $pdf->stream();
	}
	
	public function dm(){

        $asurnsi_bpjs = Asuransi::Bpjs();
		$periksas = Periksa::with('diagnosa.icd10', 'pasien')
							->where('asuransi_id', $asurnsi_bpjs->id)
							->whereRaw("tanggal like '{Carbon::CreateFromFormat('m-Y',Input::get('bulanTahun'))->format('Y-m')}%'" )
							->get();
		return view('laporans.bpjs.dm', [
			'periksas' => $this->periksas,
			'bulan'    => Carbon::CreateFromFormat('m-Y',Input::get('bulanTahun'))
		]);
	}
	
	public function diagnosa(){
		return view('laporans.bpjs.diagnosa', [
			'periksas' => $this->queryDiagnosaRujukan(),
			'bulan'    => Carbon::CreateFromFormat('m-Y',Input::get('bulanTahun'))
		]);
	}
	public function diagnosaPdf(){
		$pdf   = PDF::loadView(
					'laporans.bpjs.diagnosapdf', 
					[
						'periksas' => $this->queryDiagnosaRujukan(),
						'bulan'    => Carbon::CreateFromFormat('m-Y',Input::get('bulanTahun'))
					])
				->setPaper('a4');
        return $pdf->stream();
	}

	/**
	* undocumented function
	*
	* @return void
	*/
	private function queryDiagnosaRujukan()
	{
		$query  = "SELECT ";
		$query .= "prx.tanggal as tanggal, ";
		$query .= "psn.nama as nama_pasien, ";
		$query .= "psn.nomor_asuransi_bpjs as nomor_asuransi_bpjs, ";
		$query .= "concat( dgn.icd10_id, ' - ', icd.diagnosaICD ) as diagnosa ";
		$query .= "FROM periksas as prx ";
		$query .= "JOIN asuransis as asu on asu.id = prx.asuransi_id ";
		$query .= "JOIN pasiens as psn on psn.id = prx.pasien_id ";
		$query .= "JOIN diagnosas as dgn on dgn.id = prx.diagnosa_id ";
		$query .= "JOIN icd10s as icd on icd.id = dgn.icd10_id ";
		$query .= "RIGHT JOIN rujukans as rjk on rjk.periksa_id = prx.id ";
		$query .= "WHERE asu.tipe_asuransi_id = 5 ";
		$query .= "AND prx.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "AND prx.tanggal like '{Carbon::CreateFromFormat('m-Y',Input::get('bulanTahun'))->format('Y-m')}%' ";
		return DB::select($query);
	}
	/**
	* undocumented function
	*
	* @return void
	*/
	private function queryHipertensi()
	{
		$query  = "SELECT ";
		$query .= "prx.tanggal as tanggal, ";
		$query .= "psn.nama as nama_pasien, ";
		$query .= "psn.nomor_asuransi_bpjs as nomor_asuransi_bpjs, ";
		$query .= "prx.sistolik as sistolik, ";
		$query .= "prx.diastolik as diastolik, ";
		$query .= "psn.tanggal_lahir as tanggal_lahir, ";
		$query .= "TIMESTAMPDIFF(YEAR, psn.tanggal_lahir, CURDATE()) AS age ";
		$query .= "FROM periksas as prx ";
		$query .= "JOIN pasiens as psn on psn.id = prx.pasien_id ";
		$query .= "JOIN asuransis as asu on asu.id = prx.asuransi_id ";
		$query .= "RIGHT JOIN rujukans as rjk on rjk.periksa_id = prx.id ";
		$query .= "WHERE asu.tipe_asuransi_id = 5 ";
		$query .= "AND prx.tanggal like '{Carbon::CreateFromFormat('m-Y',Input::get('bulanTahun'))->format('Y-m')}%' ";
		$query .= "AND prx.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "AND prx.sistolik not like '' ";
		$query .= "AND prx.diastolik not like '' ";
		return DB::select($query);
	}

	public function dmBerobat($bulanThn){
		$laporan = new LaporansController;

		$query  = "SELECT ";
		$query .= "psn.nama, ";
		$query .= "prx.id as periksa_id, ";
		$query .= "psn.tanggal_lahir, ";
		$query .= "psn.alamat, ";
		$query .= "prx.tanggal, ";
		$query .= "trx.jenis_tarif_id, ";
		$query .= "trx.biaya, ";
		$query .= "trx.keterangan_pemeriksaan, ";
		$query .= "psn.id as pasien_id, ";
		$query .= "CAST(trx.keterangan_pemeriksaan AS UNSIGNED) as ket_pemeriksaan ";
		$query .= "FROM periksas as prx ";
		$query .= "LEFT JOIN transaksi_periksas as trx on prx.id = trx.periksa_id ";
		$query .= "JOIN pasiens as psn on psn.id = prx.pasien_id ";
		$query .= "WHERE psn.prolanis_dm=1 ";
		$query .= "AND prx.tanggal like '" . $bulanThn. "%' ";
		$query .= "AND prx.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "ORDER BY keterangan_pemeriksaan asc";
		$dm = DB::select($query);

		$result = [];
		foreach ($dm as $d) {
			$result[$d->periksa_id] = [
				'nama'          => $d->nama,
				'tanggal_lahir' => $d->tanggal_lahir,
				'alamat'        => $d->alamat,
			];
			$result[$d->periksa_id]['pemeriksaan'][] = [
				'jenis_tarif_id'         => $d->jenis_tarif_id,
				'biaya'                  => $d->biaya,
				'keterangan_pemeriksaan' => $d->keterangan_pemeriksaan
			];
		}
		dd( $result );
		return view('laporans.dm_terkendali', compact(
			'result'
		));
	}
	public function dmTerkendali($bulanThn){
		$prx         = new PeriksasController;
		$data_dm = $prx->hitungPersentaseRppt($bulanThn)['data_dm'];
		$bulanThn    = Carbon::createFromFormat('Y-m', $bulanThn);
		$prolanis_dm = [];
		foreach ($data_dm as $dm) {
			$prolanis_dm[] = $dm;
		}
		return view('laporans.dm_terkendali', compact(
			'bulanThn',
			'prolanis_dm'
		));
	}
	public function htBerobat($bulanThn){
		$pdf         = new PdfsController;
		$prolanis_ht = $pdf->prolanisHT($bulanThn);
		$bulanThn    = Carbon::createFromFormat('Y-m', $bulanThn);
		return view('laporans.bpjs_ht_berobat', compact(
			'bulanThn',
			'prolanis_ht'
		));
	}
	public function htTerkendali($bulanThn){
		$prx         = new PeriksasController;
		$prolanis_ht = $prx->hitungPersentaseRppt($bulanThn)['data_ht'];
		$bulanThn    = Carbon::createFromFormat('Y-m', $bulanThn);

		/* dd( $prolanis_ht ); */

		return view('laporans.bpjs_ht_terkendali', compact(
			'bulanThn',
			'prolanis_ht'
		));
	}
}
