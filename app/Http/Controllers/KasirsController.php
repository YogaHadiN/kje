<?php

namespace App\Http\Controllers;

use Input;
use Carbon\Carbon;
use App\Http\Controllers\PengeluaransController;
use App\Http\Controllers\WablasController;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Http\Requests;
use App\Console\Commands\scheduleBackup;
use Moota;
use DB;
use App\Models\Saldo;
use App\Models\Coa;
use App\Models\DenominatorBpjs;
use App\Models\CheckoutKasir;
use App\Models\JurnalUmum;
use App\Models\PasienProlanis;
use App\Models\PesertaBpjsPerbulan;
use App\Models\Classes\Yoga;
use App\Models\Sms;
use App\Models\Periksa;
/* use Vultr\VultrClient; */
/* use Vultr\Adapter\GuzzleHttpAdapter; */

class KasirsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 * GET /kasirs
	 *
	 * @return Response
	 */

	public function saldo(){
		$moota_balance = Moota::balance()['balance'];

		/* $wablas     = new WablasController; */
		/* $infoWablas = $wablas->infoWablas(); */

		/* $quota      = $infoWablas['quota']; */
		/* $expired    = $infoWablas['expired']; */

		$pasien_pertama_belum_dikirim = $this->pasienPertamaBelumDikirim();

		/* dd($pasien_pertama_belum_dikirim); */
		/* $vultr                = $this->vultr(); */

		$status = 'success';

		$admedikaWarning = 'primary';
		//jika pasien admedika yang belum dikirim ada 25 hari yang lalu, maka warning
		//
		if ( $this->countDay( $pasien_pertama_belum_dikirim  ) > 20) {
			$status          = 'warning';
			$admedikaWarning = 'warning';
		} 

		//
		//jika balance vultr kurang dari 20 maka warning
		//
		//
		/* $vultrWarning = 'primary'; */
		/* if( ($vultr['balance'] + $vultr['pending_charges']) > -20 ){ */
		/* 	$status = 'warning'; */
		/* 	$vultrWarning = 'warning'; */
		/* } */

		//
		//jika balance moota kurang dari 20000 maka warning
		//
		$mootaWarning = 'primary';
		if( $moota_balance < 20000 ){
			$status = 'warning';
			$mootaWarning = 'warning';
		}

		//
		//jika sudah tanggal 6 dan belum diupload daftar peserta bpjs bulan itu maka warning
		//
		//

		$statusBpjsPerBulan   = 'primary';
		// ==========================================================================================
		// HALT BPJS PERBULAN
		// ==========================================================================================
		//
		//
		/* $peserta_bpjs_perbulan = PesertaBpjsPerbulan::where('created_at', 'like', date('Y-m') . '%')->first(); */

		/* if ( date('d') > 6 && is_null( $peserta_bpjs_perbulan ) ) { */
		/* 	$statusBpjsPerBulan = 'warning'; */
		/* 	$status             = 'warning'; */
		/* } */

		$wablasWarning        = 'primary';
		/* if( $quota < 1000 ){ */
		/* 	$status = 'warning'; */
		/* 	$wablasWarning = 'warning'; */
		/* } */

		/* if( Yoga::dateDiffNow($expired) < 10 ){ */
		/* 	$status = 'warning'; */
		/* 	$wablasWarning = 'warning'; */
		/* } */

		if( $moota_balance < 10000 ){
			$status = 'danger';
			$mootaWarning = 'danger';
		}
		/* if( ($vultr['balance'] + $vultr['pending_charges']) > -15 ){ */
		/* 	$status       = 'danger'; */
		/* 	$vultrWarning = 'danger'; */
		/* } */

		if ( $this->countDay( $pasien_pertama_belum_dikirim  ) > 24) {
			$status          = 'danger';
			$admedikaWarning = 'danger';
		} 

		/* if( $quota < 500 ){ */
		/* 	$status        = 'danger'; */
		/* 	$wablasWarning = 'danger'; */
		/* } */

		/* if( Yoga::dateDiffNow($expired) < 3 ){ */
		/* 	$status        = 'danger'; */
		/* 	$wablasWarning = 'danger'; */
		/* } */

		
		//
		//jika sudah diatas tanggal 15 dan belum diupload daftar peserta bpjs bulan itu maka fail
		//
		//

		// ==========================================================================================
		// HALT BPJS PERBULAN
		// ==========================================================================================
		//
		//
		/* if ( date('d') >10 && is_null( $peserta_bpjs_perbulan ) ) { */
		/* 	$statusBpjsPerBulan = 'danger'; */
		/* 	$status             = 'danger'; */
		/* } */

		$saldos     = Saldo::with('staf')->latest()->paginate(20);
		$jarak_hari = $this->countDay( $pasien_pertama_belum_dikirim  );

		// ==========================================================================================
		// INPUT DATA DENOMINATOR BPJS SETIAP BULAN
		// ==========================================================================================
		//
		//
		$denominatorBpjsBulanIniAda = DenominatorBpjs::where('bulanTahun', 'like', date('Y-m') . '%')->exists();

		/* dd( ' $denominatorBpjsBulanIniAda ',  $denominatorBpjsBulanIniAda ); */

		$denominatorBpjsWarning = 'primary';

		if ( date('j') > 6 && !$denominatorBpjsBulanIniAda ) {
			$status                 = 'warning';
			$denominatorBpjsWarning = 'warning';
		} 

		if ( date('j') > 14 && !$denominatorBpjsBulanIniAda) {
			$status                 = 'danger';
			$denominatorBpjsWarning = 'danger';
		} 


		// ==========================================================================================
		// UPLOAD DATA PESERTA BPJS TIAP BULAN
		// ==========================================================================================
		//
		//
		$pasienProlanisBulanIniSudahDiupload  = PasienProlanis::where('created_at', 'like', date('Y-m') . '%')->exists();
		$uploadDataPesertaBpjsWarning = 'primary';

		if ( date('j') > 6 && !$pasienProlanisBulanIniSudahDiupload  ) {
			$status                       = 'warning';
			$uploadDataPesertaBpjsWarning = 'warning';
		} 

		if ( date('j') > 14 && !$pasienProlanisBulanIniSudahDiupload ) {
			$status                       = 'danger';
			$uploadDataPesertaBpjsWarning = 'danger';
		} 

		/* dd( ' $pasienProlanisBulanIniSudahDiupload ', $pasienProlanisBulanIniSudahDiupload ); */

		// ==========================================================================================
		// VALIDASI DATA PROLANIS BPJS YANG SUDAH DIUPLOAD
		// ==========================================================================================
		//
		//
		/* $validasiProlanisBpjsWarning = 'primary'; */


		/* // Jika data peserta bpjs sudah diupload */
		/* if ($pasienProlanisBulanIniSudahDiupload) { */

		/* 	// Cari pasien yang memiliki image kartu bpjs dan masuk dalam pasien_prolanis bulan ini */
		/* 	$bulanIni               = date('Y-m'); */
		/* 	$query                  = "SELECT count(ppr.id) as count "; // cari semua */
		/* 	$query                 .= "FROM pasien_prolanis as ppr "; */
		/* 	$query                 .= "JOIN pasiens as psn on psn.id = ppr.pasien_id "; */
		/* 	$query                 .= "WHERE ppr.created_at like '{$bulanIni}%' "; */
		/* 	$query                 .= "AND ppr.tenant_id = " . session()->get('tenant_id') . " "; */
		/* 	$query                 .= "AND ( psn.verifikasi_prolanis_dm_id = 1 or psn.verifikasi_prolanis_ht_id = 1 )"; */
		/* 	$query                 .= "AND ( psn.bpjs_image is not null and psn.bpjs_image not like '' ) "; */
		/* 	$pasienBelumDivalidasi  = DB::select($query); */

		/* 	if ( date('j') > 6 && count($pasienBelumDivalidasi) > 1) { */
		/* 		$status                      = 'warning'; */
		/* 		$validasiProlanisBpjsWarning = 'warning'; */
		/* 	} */ 

		/* 	if ( date('j') > 14 && count($pasienBelumDivalidasi) > 1) { */
		/* 		$status                      = 'danger'; */
		/* 		$validasiProlanisBpjsWarning = 'danger'; */
		/* 	} */ 
		/* } */

		// ==========================================================================================
		// VALIDASI Verifikasi kalau tagihan admedika sudah diterima
		// ==========================================================================================
		//
		//
		//
		
		// Cari invoice dengan asuransi admedika 
		// selama 5 bulan terakhir
		// yang kolom received_verification nya null
		//

		/* $invC = new InvoiceController; */
		/* $invoiceBelumDiterimaAdmedika = $invC->queryPendingReceivedVerification(); */


		/* // Jika invoice terakhir sudah dikirim 1 minggu yang lalu, maka */ 
		/* $validateReceivedVerification = 'primary'; */
		/* if ( */ 
		/* 	count($invoiceBelumDiterimaAdmedika)  && */
		/* 	day_diff( $invoiceBelumDiterimaAdmedika[0]->created_at, date('Y-m-d') ) > 7 */ 
		/* ) { */
		/* 	$status                      = 'warning'; */
		/* 	$validateReceivedVerification = 'warning'; */
		/* } */


		/* if ( */
		/* 	count($invoiceBelumDiterimaAdmedika)  && */
		/* 	day_diff( $invoiceBelumDiterimaAdmedika[0]->created_at, date('Y-m-d') ) > 14 */ 
		/* ) { */
		/* 	$status                      = 'danger'; */
		/* 	$validateReceivedVerification = 'danger'; */
		/* } */

		/* dd( $status ); */

		return view('kasirs.saldo', compact(
			'saldos',
			'admedikaWarning',
			/* 'invoiceBelumDiterimaAdmedika', */
			/* 'validateReceivedVerification', */
			'denominatorBpjsWarning',
			/* 'validasiProlanisBpjsWarning', */
			'pasienProlanisBulanIniSudahDiupload',
			'uploadDataPesertaBpjsWarning',
			'mootaWarning',
			'status',
			'pasien_pertama_belum_dikirim',
			'jarak_hari',
			'moota_balance'
		));
	}
	
	public function saldoPost(){
		$rules = [
			'saldo'   => 'required',
			'staf_id' => 'required',
		];
		
		$validator = \Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
		{
			return \Redirect::back()->withErrors($validator)->withInput();
		}
		$saldo          = Yoga::clean( Input::get('saldo') );
		$saldo_saat_ini = 0;
		$selisih        = 0;

        $query  = "DELETE FROM jurnal_umums where id in (Select jur.id as id FROM jurnal_umums as jur left join periksas as prx on prx.id = jur.jurnalable_id where jurnalable_type = 'App\\\Models\\\Periksa' and prx.id is null);";
        $data = DB::statement($query);

		$checkout       = new PengeluaransController;
		$saldo_saat_ini = $checkout->parameterKasir()['uang_di_kasir'];

		$selisih = $saldo - $saldo_saat_ini;

		$sl                 = new Saldo;
		$sl->saldo          = $saldo;
		$sl->saldo_saat_ini = $saldo_saat_ini;
		$sl->selisih        = $selisih;
		$sl->staf_id        = Input::get('staf_id');
		$confirm            = $sl->save();

		//backup database
		/* $kernel = new scheduleBackup; */
		/* $kernel->handle(); */

		if ($selisih > 0) {
			$pesanSms = 'Ada kelebihan uang di kasir sebesar ' . Yoga::buatrp($selisih). 'saldo di kasir sebesar ' . Yoga::buatrp($saldo_saat_ini);
			Sms::send(env("NO_HP_OWNER"),  $pesanSms );
			Sms::send(env("NO_HP_OWNER2"), $pesanSms  );
		} else if( $selisih < 0 ){
			$pesanSms = 'Ada kekurangan uang di kasir sebesar ' . Yoga::buatrp($selisih). 'saldo di kasir sebesar ' . Yoga::buatrp($saldo_saat_ini);
			Sms::send(env("NO_HP_OWNER"), $pesanSms );
			Sms::send(env("NO_HP_OWNER2"), $pesanSms);
		}

		if ($confirm) {
			$pesan = Yoga::suksesFlash('Penghitungan Saldo <strong>BERHASIL</strong> dilakukan');
		} else {
			$pesan = Yoga::gagalFlash('Penghitungan Saldo <strong>GAGAL</strong> dilakukan');
		}
		return redirect()->back()->withPesan($pesan);
	}
	private function secondsToTime($seconds) {
		$dtF = new \DateTime('@0');
		$dtT = new \DateTime("@$seconds");
		return $dtF->diff($dtT)->format('%a hari lagi');
	}
	/* private	function vultr(){ */
	/* 	$client = new VultrClient( */
	/* 		new GuzzleHttpAdapter(env('VULTR_KEY')) */
	/* 	); */
	/* 	$result = $client->metaData()->getAccountInfo(); */
	/* 	return $result; */
	/* } */
	public function pasienPertamaBelumDikirim(){
		
		$query  = "SELECT ";
		$query .= "px.tanggal, ";
		$query .= "px.jam, ";
		$query .= "px.id as periksa_id, ";
		$query .= "ps.id as pasien_id, ";
		$query .= "asu.nama as nama_asuransi, ";
		$query .= "ps.nama as nama_pasien ";
		$query .= "FROM periksas as px ";
		$query .= "JOIN pasiens as ps on ps.id = px.pasien_id ";
		$query .= "JOIN asuransis as asu on asu.id = px.asuransi_id ";
		$query .= "JOIN tipe_asuransis as ta on ta.id = asu.tipe_asuransi_id ";
		$query .= "WHERE invoice_id is null ";
		$query .= "AND px.tanggal > '2020-12-31' ";
		$query .= "AND px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "AND ta.id = 3 "; // tipe asuransi admedika
		$query .= "ORDER BY px.tanggal asc ";
		$query .= "LIMIT 1 ";

		$pasienBelumDikirim = DB::select($query);
		if ( count( $pasienBelumDikirim )  ) {
			return $pasienBelumDikirim[0];
		}

		return null;

	}
	private function countDay($pasienBelumDikirim){
		if ( is_null($pasienBelumDikirim) ) {
			return 0;
		}
		$now = time(); // or your date as well
		$your_date = strtotime($pasienBelumDikirim->tanggal);
		$datediff = $now - $your_date;
		return round($datediff / (60 * 60 * 24));
	}
	public function keluar_masuk_kasir(){
		$jurnal_umum_id = CheckoutKasir::latest()->first()->jurnal_umum_id;
		/* $jurnal_umum_id = CheckoutKasir::latest()->limit(2)->first()->jurnal_umum_id; */
		$jurnal_umums   = JurnalUmum::with('jurnalable')
								  ->where('coa_id', Coa::where('kode_coa', '110000' )->first()->id)
								  ->where('id', '>', $jurnal_umum_id)
								  ->orderBy('id', 'desc')
								  ->get();
		return view('kasirs.keluar_masuk_kasir', compact(
			'jurnal_umums'
		));
	}

}
