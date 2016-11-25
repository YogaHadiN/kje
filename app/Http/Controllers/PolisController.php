<?php
namespace App\Http\Controllers;
use Input;
use App\Http\Requests;
use App\AntrianPeriksa;
use App\Classes\Yoga;
use App\TujuanRujuk;
use App\Periksa;
use App\Pasien;
use App\AturanMinum;
use App\Staf;
use App\Signa;
use App\Diagnosa;
use App\Icd10;
use App\Tarif;
use App\Asuransi;
use App\GambarPeriksa;
use File;

class PolisController extends Controller
{
	public function poli($id){

		$antrianperiksa 		= AntrianPeriksa::with('pasien')->where('id', $id)->first();


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

		$pemeriksaan_awal 	= '';
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

		
		$periksa     = Periksa::with('terapii.merek', 'rujukan', 'suratSakit')->where('pasien_id', $pasien_id)->latest()->first();
		$asuransi_id = $antrianperiksa->asuransi_id;
		$pasien      = $antrianperiksa->pasien;

		$aturans     = \Cache::remember('aturans', 60, function(){
			 return  AturanMinum::orderBy('id', 'desc')->get();
		});

		$aturanlist =  \Cache::remember('aturanlist', 60, function(){
            return AturanMinum::lists('aturan_minum', 'id')->all();
		});
		
		$stafs     = \Cache::remember('stafs', 60, function(){
            return Staf::lists('nama', 'id')->all();
		});

		$signa     = \Cache::remember('signa', 60, function(){
            return Signa::lists('signa', 'id')->all();
		});
		$signas     = \Cache::remember('signas', 60, function(){
            return Signa::orderBy('id', 'desc')->get()->take(10);
		});

		$diagnosa     = \Cache::remember('diagnosa', 60, function(){
            return Diagnosa::with('icd10')->get()->lists('diagnosa_icd', 'id')->all();
		});

		$icd10s     = \Cache::remember('icd10s', 60, function(){
			return Icd10::all()->take(10);
		});

        if($asuransi_id == '32'){
            $tindakans   = [null => '- Pilih -'] + Tarif::where('asuransi_id', $asuransi_id)->where('jenis_tarif_id', '>', '10')->with('jenisTarif')->get()->lists('jenisbpjs', 'tarif_jual')->toArray();
        }else{
            $tindakans   = [null => '- Pilih -'] + Tarif::where('asuransi_id', $asuransi_id)->where('jenis_tarif_id', '>', '10')->with('jenisTarif')->get()->lists('jenis_tarif_list', 'tarif_jual')->toArray();
        }
		$periksaExist = Periksa::where('antrian_periksa_id', $antrianperiksa->id)->first();
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

		$keterangan     = \Cache::remember('keterangan', 60, function(){
			return Asuransi::find(32);
		});
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

			if ($periksa->usg) {
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
			$url = url('/');
			$text = 'http://www.google.com';
			//return $periksaExist->gambarPeriksa->count();
			return view('poliedit')
			->withAntrianperiksa($antrianperiksa)
			->withDiagnosa($diagnosa)
			->withUrl($url)
			->withText($text)
			->withIcd10s($icd10s)
			->withPasien($pasien)
			->withSignas($signas)
			->withBukus($bukus)
			->withConfirms($confirms)
			->withRefleks_patelas($refleks_patelas)
			->withKepala_terhadap_paps($kepala_terhadap_paps)
			->withPresentasis($presentasis)
			->withStafs($stafs)
			->withSigna($signa)
			->withAturans($aturans)
			->withTujuan_rujuk($tujuan_rujuk)
			->withTrp($terapiArray)
			->withAturanlist($aturanlist)
			->withTindakans($tindakans)
			->withSudah($sudah)
			->withPeriksa($periksa)
			->withPemeriksaan_awal($pemeriksaan_awal)
			->withTransaksi($transaksi)
			->withPeriksaex($periksaExist)
			->withPresentasi($presentasi)
			->withPenunjang($periksaExist->pemeriksaan_penunjang)
			->withBpdw($bpdw)
			->withBpdd($bpdd)
			->withBpd_mm($bpd_mm)
			->withHcw($hcw)
			->withHcd($hcd)
			->withHc_mm($hc_mm)
			->withFl_mm($fl_mm)
			->withAc_mm($ac_mm)
			->withPerujuk_id($perujuk_id)
			->withLtp($ltp)
			->withAdatindakan('0')
			->withPakai_bayar_pribadi($pakai_bayar_pribadi)
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
			->withJumlah_janin($jumlah_janin)
			->withNama_suami($nama_suami)
			->withBb_sebelum_hamil($bb_sebelum_hamil)
			->withGolongan_darah($golongan_darah)
			->withRencana_penolong($rencana_penolong)
			->withRencana_tempat($rencana_tempat)
			->withRencana_pendamping($rencana_pendamping)
			->withRencana_transportasi($rencana_transportasi)
			->withRencana_pendonor($rencana_pendonor)
			->withTd($td)
			->withBb($bb)
			->withTfu($tfu)
			->with('cekGdsBulanIni', $cekGdsBulanIni)
			->withLila($lila)
			->withDjj($djj)
			->withRegister_hamil_id($register_hamil_id)
			->withStatus_imunisasi_tt_id($status_imunisasi_tt_id)
			->withBuku_id($buku_id)
			->withRefleks_patela_id($refleks_patela_id)
			->withKepala_terhadap_pap_id($kepala_terhadap_pap_id)
			->withPresentasi_id($presentasi_id)
			->withCatat_di_kia($catat_di_kia)
			->withRiwayat_persalinan_sebelumnya($riwayat_persalinan_sebelumnya)
			->withHpht($hpht)
			->withTanggal_lahir_anak_terakhir($tanggal_lahir_anak_terakhir)
			->withSaran($saran);


            }
        
		$plafonFlat = Yoga::dispensingObatBulanIni($antrianperiksa->asuransi);
		$sudah = false;
		$periksaBulanIni = Periksa::where('pasien_id', $pasien_id)->where('tanggal', 'like', date('Y-m') . '%')->where('asuransi_id', '32')->get();

		foreach ($periksaBulanIni as $periksa) {
			if(preg_match('/Gula Darah/',$periksa->pemeriksaan_penunjang)){
				$sudah = true;
				break;				
			}
		}
		$periksaExist = false;
		$penunjang    = '';
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
			$penunjang = 'USG : ,';
		} else if($antrianperiksa->poli == 'sks'){
			$transaksiusg[] = [
				'jenis_tarif_id'      => '121',
				'jenis_tarif'         => 'surat keterangan sehat',
				'biaya'               => Tarif::where('asuransi_id', $antrianperiksa->asuransi_id)
										->where('jenis_tarif_id', '121')->first()->biaya,
				'keterangan_tindakan' => ''
			];
			$penunjang = 'surat keterangan sehat : , ';
		} else if($antrianperiksa->poli == 'kb 1 bulan'){
			$transaksiusg[] = [
				'jenis_tarif_id'      => '70',
				'jenis_tarif'         => 'kb 1 bulan',
				'biaya'               => Tarif::where('asuransi_id', $antrianperiksa->asuransi_id)
										->where('jenis_tarif_id', '70')->first()->biaya,
				'keterangan_tindakan' => ''
			];
			$penunjang = 'KB 1 Bulan : , ';
		} else if($antrianperiksa->poli == 'kb 3 bulan'){
			$transaksiusg[] = [
				'jenis_tarif_id'      => '72',
				'jenis_tarif'         => 'kb 3 bulan',
				'biaya'               => Tarif::where('asuransi_id', $antrianperiksa->asuransi_id)
										->where('jenis_tarif_id', '72')->first()->biaya,
				'keterangan_tindakan' => ''
			];
			$penunjang = 'KB 3 Bulan : , ';
		}
		//entry untuk menentukan apakah akan ada tindakan atau tidak
		$adatindakan = '0';

		if ($antrianperiksa->poli == 'luka') {
			$adatindakan = '1';
		}
		$transaksiusg = json_encode($transaksiusg);
		$pakai_bayar_pribadi = Yoga::pakaiBayarPribadi($antrianperiksa->asuransi_id, $antrianperiksa->pasien_id, $periksa);

		$url = url('/');
		//return dd( $antrianperiksa->gambars );
		//return dd( $periksa->gambars );
		
		return view('poli')
			->withAntrianperiksa($antrianperiksa)
			->withDiagnosa($diagnosa)
			->withUrl($url)
			->withIcd10s($icd10s)
			->withPasien($pasien)
			->withPakai_bayar_pribadi($pakai_bayar_pribadi)
			->withKepala_terhadap_paps($kepala_terhadap_paps)
			->withPresentasis($presentasis)
			->withRefleks_patelas($refleks_patelas)
			->withConfirms($confirms)
			->withBukus($bukus)
			->withSignas($signas)
			->withTujuan_rujuk($tujuan_rujuk)
			->withSigna($signa)
			->withStafs($stafs)
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
			->withPemeriksaan_awal($pemeriksaan_awal);
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

}
