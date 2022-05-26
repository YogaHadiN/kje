<?php
namespace App\Http\Controllers;
use Input;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\AntrianPolisController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\SuratSakitsController;
use App\Events\updateMonitor;
use App\Models\AntrianPeriksa;
use App\Models\Antrian;
use App\Models\Classes\Yoga;
use App\Models\TujuanRujuk;
use App\Models\Periksa;
use App\Models\Panggilan;
use App\Models\Pasien;
use App\Models\AturanMinum;
use App\Models\Staf;
use App\Models\Signa;
use App\Models\Generik;
use App\Models\Diagnosa;
use App\Models\Icd10;
use App\Models\Tarif;
use App\Models\Asuransi;
use App\Models\GambarPeriksa;
use File;

class PolisController extends Controller
{


	public function __construct() {

        /* $this->middleware('harusUrut', ['only' => ['poli']]); */
    }
	public function poli($id, Request $request){
		$generik_list   = Generik::list();
		$asuransi_list  = Asuransi::list();
		$antrianperiksa = AntrianPeriksa::with('gambars',
												'pasien.alergies', 
												'antrian.jenis_antrian', 
												'asuransi',
												'staf'
												)->where('id',$id)->first();
		if ($antrianperiksa == null) {
			$pesan = Yoga::gagalFlash('Pasien sudah dimasukkan sebelumnya atau buatlah antrian baru');
			return redirect()->back()->withPesan($pesan);
		}

		if ( $antrianperiksa->asuransi_id == '32' && empty( $antrianperiksa->pasien->image ) ) {
			return redirect('pasiens/' . $antrianperiksa->pasien_id . '/edit')
				->withCek('Gambar <strong>Foto pasien (bila anak2) atau gambar KTP pasien (bila DEWASA) </strong> harus dimasukkan terlebih dahulu')
				->withBack( 'poli/' . $id );
		}
		$pasien_id 				= $antrianperiksa->pasien_id;
		$tekanan_darah 			= $antrianperiksa->tekanan_darah;
		$suhu 					= $antrianperiksa->suhu;
		$berat_badan 			= $antrianperiksa->berat_badan;
		$tinggi_badan 			= $antrianperiksa->tinggi_badan;

		$ss                        = new SuratSakitsController;
		$dikasiDalam1BulanTerakhir = $ss->dikasiDalam1BulanTerakhir($pasien_id);

		$pemeriksaan_awal    = '';
		$pakai_bayar_pribadi = false;

		$g = null;
		$p = null;
		$a = null;
			
		$uk                            = null;                    
		$tb                            = null;                    
		$jumlah_janin                  = null;          
		$nama_suami                    = null;            
		$bb_sebelum_hamil              = null;      
		$golongan_darah                = null;        
		$rencana_penolong              = null;      
		$rencana_tempat                = null;        
		$rencana_pendamping            = null;    
		$rencana_transportasi          = null;  
		$rencana_pendonor              = null;      
		$td                            = null;
		$bb                            = null;                    
		$tfu                           = null;                   
		$lila                          = null;                  
		$djj                           = null;                   
		$register_hamil_id             = null;     
		$status_imunisasi_tt_id        = null;
		$buku_id                       = null;               
		$refleks_patela_id             = null;     
		$kepala_terhadap_pap_id        = null;
		$presentasi_id                 = null;         
		$catat_di_kia                  = null;          
		$riwayat_persalinan_sebelumnya = null;
		$hpht                          = null;
		$tanggal_lahir_anak_terakhir   = null;

		$confirms             = Yoga::confirmList();
		$refleks_patelas      = Yoga::refleksPatelasList();
		$kepala_terhadap_paps = Yoga::kepalaTerhadapPapsList();
		$presentasis          = Yoga::presentasisList();
		$bukus                = Yoga::bukusList();

		Yoga::registerHamilList($pasien_id);

		if($tekanan_darah){
			$pemeriksaan_awal .= $tekanan_darah . ' mmHg ';
		}
		if($suhu){
			$pemeriksaan_awal .= $suhu . ' C ';
		}
		if($berat_badan){
			$pemeriksaan_awal .= $berat_badan . ' kg ';
		}
		if($tinggi_badan){
			$pemeriksaan_awal .= $tinggi_badan . ' cm ';
		}
		$specs = \Cache::remember('specs', 60, function() {	
			return TujuanRujuk::all(['tujuan_rujuk']);
		});

		$tujuan_rujuk = [];

		foreach ($specs as $sp) {
			$tujuan_rujuk[] = $sp->tujuan_rujuk;
		}

		$tujuan_rujuk = json_encode($tujuan_rujuk);

		
		$periksa     = Periksa::with(
									'terapii.merek', 
									'rujukan', 
									'suratSakit'
								)->where('pasien_id', $pasien_id)->latest()->first();
		$asuransi_id = $antrianperiksa->asuransi_id;
		$pasien      = $antrianperiksa->pasien;

		$aturans     = \Cache::remember('aturans', 60, function(){
			 return  AturanMinum::orderBy('id', 'desc')->get();
		});

		$aturanlist =  \Cache::remember('aturanlist', 60, function(){
            return AturanMinum::pluck('aturan_minum', 'id')->all();
		});
		
		$stafs     = \Cache::remember('stafs', 60, function(){
            return Staf::pluck('nama', 'id')->all();
		});

		$signa     = \Cache::remember('signa', 60, function(){
            return Signa::pluck('signa', 'id')->all();
		});
		$signas     = \Cache::remember('signas', 60, function(){
            return Signa::orderBy('id', 'desc')->get()->take(10);
		});

		$diagnosa     = \Cache::remember('diagnosa', 60, function(){
            return Diagnosa::with('icd10')->get()->pluck('diagnosa_icd', 'id')->all();
		});

		$icd10s     = \Cache::remember('icd10s', 60, function(){
			return Icd10::all()->take(10);
		});

        if($asuransi_id == '32'){
            $tindakans   = [null => '- Pilih -'] + Tarif::where('asuransi_id', $asuransi_id)->where('jenis_tarif_id', '>', '10')->with('jenisTarif')->get()->pluck('jenisbpjs', 'tarif_jual')->toArray();
        }else{
            $tindakans   = [null => '- Pilih -'] + Tarif::where('asuransi_id', $asuransi_id)->where('jenis_tarif_id', '>', '10')->with('jenisTarif')->get()->pluck('jenis_tarif_list', 'tarif_jual')->toArray();
        }

		$periksaExist = Periksa::with(
			'terapii.merek.rak', 
			'gambars'
		)->where(
			'antrian_periksa_id', $antrianperiksa->id
		)->first();

		$cekGdsBulanIni = Yoga::cekGDSBulanIni($antrianperiksa->pasien, $periksaExist); 

		if ($asuransi_id == '32') {
			if (!$cekGdsBulanIni['bayar']) { 
				foreach ($tindakans as $key => $tindakan) {
					if ($key !== '') {
						$Array = json_decode($key, true);
						if ($Array['jenis_tarif_id'] == '116') {
							 unset($tindakans[$key]);
							$tindakans['{"tarif_id":5549,"jenis_tarif_id":"116","biaya":0}'] = 'Gula Darah';
						}
					}
				}
			}
		}

		$url = url('/');
		$qr = new QrCodeController;
		if($antrianperiksa->gambars->count() < 1){
			$base64 = $qr->inPdf( 'qrcode?text=' . $url . '/antrianperiksa/' . $antrianperiksa->id . '/images' );
		} else {
			$base64 = $qr->inPdf( 'qrcode?text=' . $url . '/antrianperiksa/' . $antrianperiksa->id . '/images/edit' );
		}

		if($periksaExist != null){

			$plafonFlat = Yoga::dispensingObatBulanIni($antrianperiksa->asuransi, $periksaExist ,true);
			$transaksi = $periksaExist->transaksi;
			$transaksi = json_decode($transaksi, true);

			for ($i = count($transaksi)-1; $i >= 0; $i--) {
				if(
					$transaksi[$i]['jenis_tarif'] == 'Jasa Dokter' ||
					$transaksi[$i]['jenis_tarif'] == 'Biaya Obat'||
					$transaksi[$i]['jenis_tarif'] == 'BHP'
				){
					array_splice($transaksi, $i, 1);
				}
			}

			$periksaExist->transaksi = json_encode($transaksi);

			//CEK APAKAH SUDAH PERIKSA GDS BULAN INI
			if ($periksaExist->registerAnc) {

				$g = $periksaExist->registerAnc->registerHamil->g;
				$p = $periksaExist->registerAnc->registerHamil->p;
				$a = $periksaExist->registerAnc->registerHamil->a;

				$uk                            = $periksaExist->registerAnc->registerHamil->uk;
				$tb                            = $periksaExist->registerAnc->registerHamil->tb;
				$jumlah_janin                  = $periksaExist->registerAnc->registerHamil->jumlah_janin;
				$nama_suami                    = $periksaExist->registerAnc->registerHamil->nama_suami;
				$bb_sebelum_hamil              = $periksaExist->registerAnc->registerHamil->bb_sebelum_hamil;
				$golongan_darah                = $periksaExist->registerAnc->registerHamil->golongan_darah;
				$rencana_penolong              = $periksaExist->registerAnc->registerHamil->rencana_penolong;
				$rencana_tempat                = $periksaExist->registerAnc->registerHamil->rencana_tempat;
				$rencana_pendamping            = $periksaExist->registerAnc->registerHamil->rencana_pendamping;
				$rencana_transportasi          = $periksaExist->registerAnc->registerHamil->rencana_transportasi;
				$rencana_pendonor              = $periksaExist->registerAnc->registerHamil->rencana_pendonor;
				$td                            = $periksaExist->registerAnc->td;
				$bb                            = $periksaExist->registerAnc->bb;
				$tfu                           = $periksaExist->registerAnc->tfu;
				$lila                          = $periksaExist->registerAnc->lila;
				$djj                           = $periksaExist->registerAnc->djj;
				$registerHamil_id              = $periksaExist->registerAnc->registerHamil_id;
				$status_imunisasi_tt_id        = $periksaExist->registerAnc->registerHamil->status_imunisasi_tt_id;
				$buku_id                       = $periksaExist->registerAnc->registerHamil->buku_id;
				$refleks_patela_id             = $periksaExist->registerAnc->refleks_patela_id;
				$kepala_terhadap_pap_id        = $periksaExist->registerAnc->kepala_terhadap_pap_id;
				$presentasi_id                 = $periksaExist->registerAnc->presentasi_id;
				$catat_di_kia                  = $periksaExist->registerAnc->catat_di_kia;
				$riwayat_persalinan_sebelumnya = $periksaExist->registerAnc->registerHamil->riwayat_persalinan_sebelumnya;
				$hpht                          = $periksaExist->registerAnc->registerHamil->hpht;
				$tanggal_lahir_anak_terakhir   = $periksaExist->registerAnc->registerHamil->tanggal_lahir_anak_terakhir;
			}

			$sudah = false;
			$periksaBulanIni = Periksa::with('terapii.merek')->where('pasien_id', $pasien_id)->where('tanggal', 'like', date('Y-m') . '%')->where('asuransi_id', '32')->where('id', '<', $periksaExist->id)->get();

			foreach ($periksaBulanIni as $periksa) {
				if(preg_match('/Gula Darah/',$periksa->pemeriksaan_penunjang)){
					$sudah = true;
					break;				
				}
			}
			$terapiArray = Yoga::masukLagi($periksaExist->terapii)	;
			$terapiArray = json_encode($terapiArray);

			if (isset( $periksa->usg )) {
				$presentasi		= $periksa->usg->presentasi;
				$bpdw			= $periksa->usg->bpdw;
				$bpdd			= $periksa->usg->bpdd;
				$bpd_mm			= $periksa->usg->bpd_mm;
				$hcw			= $periksa->usg->hcw;
				$hcd			= $periksa->usg->hcd;
				$hc_mm			= $periksa->usg->hc_mm;
				$ac_mm			= $periksa->usg->ac_mm;
				$fl_mm			= $periksa->usg->fl_mm;
				$perujuk_id		= $periksa->usg->perujuk_id;
				$ltp			= $periksa->usg->ltp;
				$djj			= $periksa->usg->djj;
				$acw			= $periksa->usg->acw;
				$acd			= $periksa->usg->acd;
				$efwd			= $periksa->usg->efwd;
				$efwd			= $periksa->usg->efwd;
				$plasenta		= $periksa->usg->plasenta;
				$ica			= $periksa->usg->ica;
				$kesimpulan		= $periksa->usg->kesimpulan;
				$flw			= $periksa->usg->flw;
				$fld			= $periksa->usg->fld;
				$sex			= $periksa->usg->sex;
				$saran			= $periksa->usg->saran;
			} else {
				$presentasi		= null;
				$bpdw			= null;
				$bpdd			= null;
				$bpd_mm			= null;
				$hcw			= null;
				$hcd			= null;
				$hc_mm			= null;
				$fl_mm			= null;
				$ac_mm			= null;
				$perujuk_id		= null;
				$ltp			= null;
				$djj			= null;
				$acw			= null;
				$acd			= null;
				$efwd			= null;
				$flw			= null;
				$fld			= null;
				$sex			= null;
				$plasenta		= null;
				$ica			= null;
				$kesimpulan		= null;
				$saran			= null;
			}
			/* $url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_ADDR']; */
			$text = 'http://www.google.com';
			$befores = Periksa::where('pasien_id', $pasien->id)->orderBy('created_at', 'desc')->take(2)->get();
			if ( $befores->count() == 1 ) {
				$before = null;
			} else {
				$before = $befores[1];
			}


			$antrian_id = null;
			if (!is_null($antrianperiksa->antrian)) {
				$antrian_id = $antrianperiksa->antrian->id;
			}

			 
			//return $periksaExist->gambarPeriksa->count();
			/* dd( $dikasiDalam1BulanTerakhir ); */
			return view('poliedit')
			->withAntrianperiksa($antrianperiksa)
			->withDiagnosa($diagnosa)
			->withUrl($url)
			->withText($text)
			->withIcd10s($icd10s)
			->withBase64($base64)
			->withPasien($pasien)
			->withSignas($signas)
			->with('generik_list',$generik_list)
			->with('asuransi_list',$asuransi_list)
			->withBukus($bukus)
			->withConfirms($confirms)
			->with('refleks_patelas', $refleks_patelas)
			->with('kepala_terhadap_paps', $kepala_terhadap_paps)
			->withPresentasis($presentasis)
			->withStafs($stafs)
			->withSigna($signa)
			->withAturans($aturans)
			->with('tujuan_rujuk', $tujuan_rujuk)
			->withTrp($terapiArray)
			->withAturanlist($aturanlist)
			->withTindakans($tindakans)
			->withSudah($sudah)
			->withPeriksa($periksa)
			->with('pemeriksaan_awal', $pemeriksaan_awal)
			->withTransaksi($transaksi)
			->withPeriksaex($periksaExist)
			->withBefore($before)
			->withPresentasi($presentasi)
			->withPenunjang($periksaExist->pemeriksaan_penunjang)
			->withBpdw($bpdw)
			->withBpdd($bpdd)
			->with('bpd_mm', $bpd_mm)
			->with('antrian_id', $antrian_id)
			->withHcw($hcw)
			->withHcd($hcd)
			->with('hc_mm', $hc_mm)
			->with('dikasiDalam1BulanTerakhir', $dikasiDalam1BulanTerakhir)
			->with('fl_mm', $fl_mm)
			->with('ac_mm', $ac_mm)
			->with('perujuk_id', $perujuk_id)
			->withLtp($ltp)
			->withAdatindakan('0')
			->with('pakai_bayar_pribadi', $pakai_bayar_pribadi)
			->withDjj($djj)
			->withAcw($acw)
			->withAcd($acd)
			->withEfwd($efwd)
			->withFlw($flw)
			->withFld($fld)
			->withG($g)
			->withP($p)
			->withA($a)
			->withSex($sex)
			->withPlasenta($plasenta)
			->withIca($ica)
			->withPlafon($plafonFlat)
			->withKesimpulan($kesimpulan)
			->withUk($uk)
			->withTb($tb)
			->with('jumlah_janin', $jumlah_janin)
			->with('nama_suami', $nama_suami)
			->with('bb_sebelum_hamil', $bb_sebelum_hamil)
			->with('golongan_darah', $golongan_darah)
			->with('rencana_penolong', $rencana_penolong)
			->with('rencana_tempat', $rencana_tempat)
			->with('rencana_pendamping', $rencana_pendamping)
			->with('rencana_transportasi', $rencana_transportasi)
			->with('rencana_pendonor', $rencana_pendonor)
			->withTd($td)
			->withBb($bb)
			->withTfu($tfu)
			->with('cekGdsBulanIni', $cekGdsBulanIni)
			->withLila($lila)
			->withDjj($djj)
			->with('register_hamil_id', $register_hamil_id)
			->with('status_imunisasi_tt_id', $status_imunisasi_tt_id)
			->with('buku_id', $buku_id)
			->with('refleks_patela_id', $refleks_patela_id)
			->with('kepala_terhadap_pap_id', $kepala_terhadap_pap_id)
			->with('presentasi_id', $presentasi_id)
			->with('catat_di_kia', $catat_di_kia)
			->with('riwayat_persalinan_sebelumnya', $riwayat_persalinan_sebelumnya)
			->withHpht($hpht)
			->with('tanggal_lahir_anak_terakhir', $tanggal_lahir_anak_terakhir)
			->withSaran($saran);
            }
        
		$plafonFlat     = Yoga::dispensingObatBulanIni($antrianperiksa->asuransi);
		$antrian_id     = null;
		if (!is_null($antrianperiksa->antrian)) {
			$antrian_id = $antrianperiksa->antrian->id;
		}
		$sudah           = false;
		$periksaBulanIni = Periksa::where('pasien_id', $pasien_id)->where('tanggal', 'like', date('Y-m') . '%')->where('asuransi_id', '32')->get();

		foreach ($periksaBulanIni as $periksa) {
			if(preg_match('/Gula Darah/',$periksa->pemeriksaan_penunjang)){
				$sudah = true;
				break;				
			}
		}
		$periksaExist = false;
		$penunjang    =[];
		$transaksiusg = [];
		if ($antrianperiksa->poli == 'usg') {
			$biayaUSG = 100000;
			if ($antrianperiksa->asuransi_id=='32') {
				$sudahPernahUsg = false;
				$counts = Periksa::where('pasien_id', $antrianperiksa->pasien_id)->where('tanggal', 'like', date('Y').'%')->get();
				foreach ($counts as $k => $periksa) {
					foreach ($periksa->transaksii as $key => $value) {
						if ($value->jenis_tarif_id == '111' && $value->biaya == '0') {
							$sudahPernahUsg = true;
							break;
						}
					}
					if ($sudahPernahUsg) {
						break;
					}
				}
				if ($sudahPernahUsg) {
					$biayaUSG = 100000;
				} else {
					$biayaUSG = 0;
				}
			}
			$transaksiusg[] = [
				'jenis_tarif_id'      => '111',
				'jenis_tarif'         => 'USG',
				'biaya'               => $biayaUSG,
				'keterangan_tindakan' => ''
			];
			$penunjang[] = 'USG : ,';
		} else if($antrianperiksa->poli == 'sks'){
			$transaksiusg[] = [
				'jenis_tarif_id'      => '121',
				'jenis_tarif'         => 'surat keterangan sehat',
				'biaya'               => Tarif::where('asuransi_id', $antrianperiksa->asuransi_id)
										->where('jenis_tarif_id', '121')->first()->biaya,
				'keterangan_tindakan' => ''
			];
			$penunjang[] = 'surat keterangan sehat : , ';
		} else if($antrianperiksa->poli == 'kb 1 bulan'){
			$transaksiusg[] = [
				'jenis_tarif_id'      => '265',
				'jenis_tarif'         => 'kb 1 bulan',
				'biaya'               => Tarif::where('asuransi_id', $antrianperiksa->asuransi_id)
										->where('jenis_tarif_id', '265')->first()->biaya,
				'keterangan_tindakan' => ''
			];
			$penunjang[] = 'KB 1 Bulan : , ';
		} else if($antrianperiksa->poli == 'kb 3 bulan'){
			$transaksiusg[] = [
				'jenis_tarif_id'      => '72',
				'jenis_tarif'         => 'kb 3 bulan',
				'biaya'               => Tarif::where('asuransi_id', $antrianperiksa->asuransi_id)
										->where('jenis_tarif_id', '72')->first()->biaya,
				'keterangan_tindakan' => ''
			];
			$penunjang[] = 'KB 3 Bulan : , ';
		}
		//entry untuk menentukan apakah akan ada tindakan atau tidak
		$adatindakan = '0';

		if ($antrianperiksa->poli == 'luka') {
			$adatindakan = '1';
		}
		$pakai_bayar_pribadi = Yoga::pakaiBayarPribadi($antrianperiksa->asuransi_id, $antrianperiksa->pasien_id, $periksa);

		$url = url('/');

		if ( !empty( $antrianperiksa->gds ) ) {
			$transaksiusg[] = [
				"jenis_tarif_id"      => "116",
				"jenis_tarif"         => "Gula Darah",
				"biaya"               => 0,
				"keterangan_tindakan" => $antrianperiksa->gds
			];
			$penunjang[] = 'Gula Darah : ' . $antrianperiksa->gds .', ';
		}

		$transaksiusg = json_encode($transaksiusg);
		$penunjang_result = '';
		foreach ($penunjang as $p) {
			$penunjang_result .= $p;
		}
		$penunjang = $penunjang_result;

		/* return $pasien->alergies[0]->generik; */
		return view('poli')
			->withAntrianperiksa($antrianperiksa)
			->withDiagnosa($diagnosa)
			->withUrl($url)
			->withIcd10s($icd10s)
			->withBase64($base64)
			->withPasien($pasien)
			->with('generik_list',$generik_list)
			->with('pakai_bayar_pribadi', $pakai_bayar_pribadi)
			->with('antrian_id', $antrian_id)
			->with('kepala_terhadap_paps', $kepala_terhadap_paps)
			->withPresentasis($presentasis)
			->with('refleks_patelas', $refleks_patelas)
			->with('dikasiDalam1BulanTerakhir', $dikasiDalam1BulanTerakhir)
			->withConfirms($confirms)
			->withBukus($bukus)
			->withSignas($signas)
			->with('tujuan_rujuk', $tujuan_rujuk)
			->withSigna($signa)
			->withStafs($stafs)
			->with('generik_list', $generik_list)
			->with('asuransi_list', $asuransi_list)
			->withAturans($aturans)
			->withAturanlist($aturanlist)
			->withTindakans($tindakans)
			->withPlafon($plafonFlat)
			->withAdatindakan($adatindakan)
			->withG($g)
			->withP($p)
			->withA($a)
			->withPenunjang($penunjang)
			->with('cekGdsBulanIni', $cekGdsBulanIni)
			->withSudah($sudah)
			->withTransaksiusg($transaksiusg)
			->withPeriksa($periksa)
			->with('pemeriksaan_awal', $pemeriksaan_awal);
	}

	public function jangan(){
		return view('jangan');
	}

    private function cacheku($name, $data){
         if (!\Cache::has($name)) {
             \Cache::put($name, $data, 60);
         }
         return \Cache::get($name);
    }
	public function updateMonitor($ap){
		if (isset( $ap->antrian )) {
			$jenis_antrian                      = $ap->antrian->jenis_antrian;
			$jenis_antrian->antrian_terakhir_id = $ap->antrian->id;
			$jenis_antrian->save();
		}
		$apc = new AntrianPolisController;
		$apc->updateJumlahAntrian();
	}
	private function panggilPasien($nomor_antrian, $ruangan){
		$huruf         = strtolower(str_split($nomor_antrian)[0]);
		$angka         = substr($nomor_antrian, 1);

		$result = [];
		$result[] =	'nomorantrian';
		if ( (int)$angka < 12 || $angka == '100' ) {
			$result[] = $huruf;
			$result[] = (int) $angka;
		} else if ( (int) $angka % 100 == 0 ) {
			$angka    = str_split($angka)[0];
			$result[] = (int) $angka;
			$result[] = 'ratus';
		} else if ( (int)$angka < 20  ) {
			$angka    = substr($angka, 1);
			$result[] = $huruf;
			$result[] = (int) $angka;
			$result[] = 'belas';
		} else if ( (int)$angka < 100  ) {
			$angka = str_split($angka, 1);
			if ($angka[1] != '0') {
				$result[] = $huruf;
				$result[] = (int) $angka[0];
				$result[] = 'puluh';
				$result[] = (int) $angka[1];
			} else {
				$result[] =	$huruf;
				$result[] =	(int) $angka[0];
				$result[] =	'puluh';
			}
		} else if ( (int)$angka < 112  ) {
			$angka    = substr($angka, 1);
			$result[] = $huruf;
			$result[] = '100';
			$result[] = (int) $angka;
		} else if ( (int)$angka < 120  ) {
			$angka = substr($angka, 1);
			$angka = str_split($angka);
			$result[] =$huruf;
			$result[] ='100';
			$result[] =(int) $angka[1];
			$result[] ='belas';
		} else if ( (int)$angka < 200  ) {
			$angka = substr($angka, 1);
			$angka = str_split($angka);
			if($angka[1] != '0'){
				$result[] =	$huruf;
				$result[] =	'100';
				$result[] =	(int) $angka[0];
				$result[] ='puluh';
				$result[] =	(int) $angka[1];
			} else {
				$result[] =	$huruf;
				$result[] =	'100';
				$result[] =	(int) $angka[0];
				$result[] =	'puluh';
			}
		} else if( (int)$angka < 999  ) {
			$angka = str_split($angka);
			if(
				$angka[1] == '0' ||
				$angka[1] == '1'  &&  (int)$angka[2] < 2 
			){
				$result[] =	$huruf;
				$result[] =	(int) $angka[0];
				$result[] =	'ratus';
				$result[] =	(int) ($angka[1] . $angka[2]);
			} else if(
				(int)$angka[1] > 0 &&
				$angka[2] == '0'
			) {
				$result[] =	$huruf;
				$result[] =	(int) $angka[0];
				$result[] =	'ratus';
				$result[] =	(int) $angka[1];
				$result[] =	'puluh';
			} else if(
			   	$angka[1] == '1'
			) {
				$result[] =	$huruf;
				$result[] =	(int) $angka[0];
				$result[] =	'ratus';
				$result[] =	(int) $angka[2];
				$result[] =	'belas';
			} else {
				$result[] =	$huruf;
				$result[] =	(int) $angka[0];
				$result[] =	'ratus';
				$result[] =	(int) $angka[1];
				$result[] =	'puluh';
				$result[] =	(int) $angka[2];
			}
		}
		$result[] =	'silahkanmenuju';
		$result[] = $ruangan;
		return $result;
	}
	public function panggilPasienAjax(){
		$antrian_id                         = Input::get('antrian_id');
		$panggil_pasien                     = Input::get('panggil_pasien');
		$ruangan                            = Input::get('ruangan');
		$antrian                            = Antrian::find($antrian_id);
		$jenis_antrian                      = $antrian->jenis_antrian;
		if (
			 $antrian->antriable_type !== 'App\Models\AntrianApotek' &&
			 $antrian->antriable_type !== 'App\Models\AntrianKasir' &&
			 $antrian->antriable_type !== 'App\Models\AntrianAntrian' &&
			 $antrian->antriable_type !== 'App\Models\AntrianFarmasi'
		) {
			$jenis_antrian->antrian_terakhir_id = $antrian->id;
		}

		$jenis_antrian->updated_at          = date('Y-m-d H:i:s');
		$jenis_antrian->save();

		$antrian->touch();

		$apc                                = new AntrianPolisController;
		$apc->updateJumlahAntrian();
		return $this->panggilPasien($antrian->nomor_antrian, $ruangan);
	}
}
