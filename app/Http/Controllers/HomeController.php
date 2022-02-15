<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Models\AntrianPeriksa;
use App\Models\Classes\Yoga;
use App\Models\TujuanRujuk;
use App\Models\Periksa;
use App\Models\Pasien;
use App\Models\AturanMinum;
use App\Models\Staf;
use App\Models\Diagnosa;
use App\Models\Icd10;
use App\Models\Tarif;
use App\Models\Asuransi;
use App\Models\Signa;
use App\Models\Merek;
use App\Models\Formula;
use App\Models\DB;
use App\Models\Rak;

class HomeController extends Controller
{


	public function getPoli($id){



		$antrianperiksa 		= AntrianPeriksa::find($id);

		$pasien_id 				= $antrianperiksa->pasien_id;
		$tekanan_darah 			= $antrianperiksa->tekanan_darah;
		$suhu 					= $antrianperiksa->suhu;
		$berat_badan 			= $antrianperiksa->berat_badan;
		$tinggi_badan 			= $antrianperiksa->tinggi_badan;
	
		$pemeriksaan_awal 	= '';

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

		$specs = TujuanRujuk::all(['tujuan_rujuk']);

		$tujuan_rujuk = [];

		foreach ($specs as $sp) {
			$tujuan_rujuk[] = $sp->tujuan_rujuk;
		}

		$tujuan_rujuk = json_encode($tujuan_rujuk);

		// return $tujuan_rujuk;
		
		$periksa     = Periksa::where('pasien_id', $pasien_id)->orderBy('id', 'desc')->first();
		$asuransi_id = $antrianperiksa->asuransi_id;
		$pasien      = Pasien::find($antrianperiksa->pasien_id);
		$aturans     = AturanMinum::orderBy('id', 'desc')->get()->take(10);
		$aturanlist  = AturanMinum::pluck('aturan_minum', 'id')->all();
		$stafs       = Staf::pluck('nama', 'id')->all();
		$signa       = Signa::pluck('signa', 'id')->all();
		$signas      = Signa::orderBy('id', 'desc')->get()->take(10);
		$diagnosa    = Diagnosa::get()->pluck('diagnosa_icd', 'id')->all();
		$icd10s      = Icd10::all()->take(10);
		$tindakans   = [null => '- Pilih -'] + Tarif::where('asuransi_id', $asuransi_id)->where('jenis_tarif_id', '>', '10')->get()->pluck('jenis_tarif_list', 'tarif_jual')->all();
		$keterangan  = json_decode(Asuransi::find(32)->umum, true);
   		// return $tindakans;
		$periksaExist = Periksa::where('pasien_id', $pasien_id)->where('jam', $antrianperiksa->jam)->where('tanggal', $antrianperiksa->tanggal)->first();
		// return $periksaExist;
		// return $antrianperiksa->asuransi;
		//	HITUNG DISPENSING BULAN INI KHUSUS UNTUK TIPE ASURANSI FLAT
		
 
		if($periksaExist){
			$plafonFlat = Yoga::dispensingObatBulanIni($antrianperiksa->asuransi, $periksaExist, true);
			$transaksi = $periksaExist->transaksi;
			// return $transaksi;
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
			
			// return $periksaExist->register_anc->register_hamil->g;
			if ($periksaExist->register_anc) {
				// return var_dump($periksaExist->register_anc);
				$g = $periksaExist->register_anc->register_hamil->g;
				$p = $periksaExist->register_anc->register_hamil->p;
				$a = $periksaExist->register_anc->register_hamil->a;


				$uk                            = $periksaExist->register_anc->register_hamil->uk;
				$tb                            = $periksaExist->register_anc->register_hamil->tb;
				$jumlah_janin                  = $periksaExist->register_anc->register_hamil->jumlah_janin;
				$nama_suami                    = $periksaExist->register_anc->register_hamil->nama_suami;
				$bb_sebelum_hamil              = $periksaExist->register_anc->register_hamil->bb_sebelum_hamil;
				$golongan_darah                = $periksaExist->register_anc->register_hamil->golongan_darah;
				$rencana_penolong              = $periksaExist->register_anc->register_hamil->rencana_penolong;
				$rencana_tempat                = $periksaExist->register_anc->register_hamil->rencana_tempat;
				$rencana_pendamping            = $periksaExist->register_anc->register_hamil->rencana_pendamping;
				$rencana_transportasi          = $periksaExist->register_anc->register_hamil->rencana_transportasi;
				$rencana_pendonor              = $periksaExist->register_anc->register_hamil->rencana_pendonor;
				$td                            = $periksaExist->register_anc->td;
				$bb                            = $periksaExist->register_anc->bb;
				$tfu                           = $periksaExist->register_anc->tfu;
				$lila                          = $periksaExist->register_anc->lila;
				$djj                           = $periksaExist->register_anc->djj;
				$register_hamil_id             = $periksaExist->register_anc->register_hamil_id;
				$status_imunisasi_tt_id        = $periksaExist->register_anc->register_hamil->status_imunisasi_tt_id;
				$buku_id                       = $periksaExist->register_anc->register_hamil->buku_id;
				$refleks_patela_id             = $periksaExist->register_anc->refleks_patela_id;
				$kepala_terhadap_pap_id        = $periksaExist->register_anc->kepala_terhadap_pap_id;
				$presentasi_id                 = $periksaExist->register_anc->presentasi_id;
				$catat_di_kia                  = $periksaExist->register_anc->catat_di_kia;
				$riwayat_persalinan_sebelumnya = $periksaExist->register_anc->register_hamil->riwayat_persalinan_sebelumnya;
				$hpht                          = $periksaExist->register_anc->register_hamil->hpht;
				$tanggal_lahir_anak_terakhir   = $periksaExist->register_anc->register_hamil->tanggal_lahir_anak_terakhir;


			}

			// return 'g = ' . $g . ' p= ' . $p . ' a= ' . $a;

			$sudah = false;
			$periksaBulanIni = Periksa::where('pasien_id', $pasien_id)->where('tanggal', 'like', date('Y-m') . '%')->where('asuransi_id', '32')->where('id', '<', $periksaExist->id)->get();

			foreach ($periksaBulanIni as $periksa) {
				if(preg_match('/Gula Darah/',$periksa->pemeriksaan_penunjang)){
					$sudah = true;
					break;				
				}
			}

			$terapiArray = $periksaExist->terapiArray;


			if ($periksa->usg) {
				$presentasi		= $periksa->usg->presentasi;
				$bpdw			= $periksa->usg->bpdw;
				$bpdd			= $periksa->usg->bpdd;
				$ltp			= $periksa->usg->ltp;
				$djj			= $periksa->usg->djj;
				$acw			= $periksa->usg->acw;
				$acd			= $periksa->usg->acd;
				$efwd			= $periksa->usg->efwd;
				$flw			= $periksa->usg->flw;
				$fld			= $periksa->usg->fld;
				$sex			= $periksa->usg->sex;
				$plasenta		= $periksa->usg->plasenta;
				$ica			= $periksa->usg->ica;
				$kesimpulan		= $periksa->usg->kesimpulan;
				$saran			= $periksa->usg->saran;
			} else {
				$presentasi		= null;
				$bpdw			= null;
				$bpdd			= null;
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

			return view('poliedit')
			->withAntrianperiksa($antrianperiksa)
			->withDiagnosa($diagnosa)
			->withIcd10s($icd10s)
			->withPasien($pasien)
			->withSignas($signas)
			->withBukus($bukus)
			->withConfirms($confirms)
			->with('refleks_patelas', $refleks_patelas)
			->with('kepala_terhadap_paps', $kepala_terhadap_paps)
			->withPresentasis($presentasis)
			->withStafs($stafs)
			->withSigna($signa)
			->withAturans($aturans)
			->with('tujuan_rujuk',$tujuan_rujuk)
			->with('trp', $terapiArray)
			->withAturanlist($aturanlist)
			->withTindakans($tindakans)
			->withSudah($sudah)
			->withPeriksa($periksa)
			->with('pemeriksaan_awal', $pemeriksaan_awal)
			->withTransaksi($transaksi)
			->withPeriksaex($periksaExist)
			->withPresentasi($presentasi)
			->withBpdw($bpdw)
			->withBpdd($bpdd)
			->withLtp($ltp)
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

		$plafonFlat = Yoga::dispensingObatBulanIni($antrianperiksa->asuransi);

		// return $sudah? 'true' :'false';
		//CEK APAKAH SUDAH PERIKSA GDS BULAN INI
		$sudah = false;
		$periksaBulanIni = Periksa::where('pasien_id', $pasien_id)->where('tanggal', 'like', date('Y-m') . '%')->where('asuransi_id', '32')->get();

		foreach ($periksaBulanIni as $periksa) {
			if(preg_match('/Gula Darah/',$periksa->pemeriksaan_penunjang)){
				$sudah = true;
				break;				
			}
		}
		$periksaExist = false;
		return view('poli')
			->withAntrianperiksa($antrianperiksa)
			->withDiagnosa($diagnosa)
			->withIcd10s($icd10s)
			->withPasien($pasien)
			->with('kepala_terhadap_paps', $kepala_terhadap_paps)
			->withPresentasis($presentasis)
			->with('refleks_patelas', $refleks_patelas)
			->withConfirms($confirms)
			->withBukus($bukus)
			->withSignas($signas)
			->with('tujuan_rujuk', $tujuan_rujuk)
			->withSigna($signa)
			->withStafs($stafs)
			->withAturans($aturans)
			->withAturanlist($aturanlist)
			->withTindakans($tindakans)
			->withPlafon($plafonFlat)
			->withG($g)
			->withP($p)
			->withA($a)
			->withSudah($sudah)
			->withPeriksa($periksa)
			->with('pemeriksaan_awal', $pemeriksaan_awal)
			->withPeriksaex($periksaExist);

	}
	public function getKasir($id){

		$periksa = Periksa::find($id);
		//Cek apakah ada gula darah yang diperiksa bulan ini termasuk sekarang
		$sudah = false;
		$periksaBulanIni = Periksa::where('pasien_id', $periksa->pasien_id)->where('tanggal', 'like', date('Y-m') . '%')->where('asuransi_id', '32')->where('id', '<', $id)->get();

		foreach ($periksaBulanIni as $prx) {
			if(preg_match('/Gula Darah/',$prx->pemeriksaan_penunjang)){
				$sudah = true;
				break;				
			}
		}

		$pasien_id = $periksa->pasien_id;
		$periksa_id = $periksa->id;

		// return $periksa_id;
		$signas = Signa::all();	
		if(empty($periksa->terapi) || $periksa->terapi == '[]'){
			$reseps = [];
		} else {
			$reseps = json_decode($periksa->terapi, true);
		}
   		$mereks = Merek::orderBy('id', 'desc')->get();
   		// return $periksa->terapi;
   		
   		$biayatotal = Yoga::biayaObatTotal($periksa->transaksi);

        
		foreach ($reseps as $key => $value) {
			
			$reseps[$key]['harga_jual'] = $mereks->find($reseps[$key]['merek_id'])->rak->harga_jual;
		}

		$asuransi_id = $periksa->asuransi_id;
		$tarif = Tarif::all();
		$pasien = Pasien::find($periksa->pasien_id);
   		$tindakans = [null => '- Pilih -'] + Tarif::where('asuransi_id', $asuransi_id)->get()->pluck('jenis_tarif_list', 'tarif_jual')->all();
   		$transaksi = $periksa->transaksi;

   		$resepjson = json_encode($reseps);

   		//	HITUNG DISPENSING BULAN INI KHUSUS UNTUK TIPE ASURANSI FLAT
		$plafonFlat = Yoga::dispensingObatBulanIni($periksa->asuransi, true);
		// return $periksa->asuransi_id;
		return view('kasir')
			->withPasien($pasien)
			->withSignas($signas)
			->withSudah($sudah)
			->withReseps($reseps)
			->withResepjson($resepjson)
			->withTindakans($tindakans)
			->withBiayatotal($biayatotal)
			->withTransaksi($transaksi)
			->withPeriksa($periksa)
			->withMereks($mereks);
	}

	public function postAjaxformula(){

		if(Input::ajax()){
			$komposisis = Input::get('json');

				$MyArray = $komposisis;
				//validasi merek
				if(count($MyArray) == 1 ){
					$merek = ucwords(strtolower(Input::get('merek'))) . ' ' . Input::get('sediaan') . ' ' . $MyArray[0]['bobot'];;
				} else {
					$merek = ucwords(strtolower(Input::get('merek'))) . ' ' . Input::get('sediaan');
				}

				if(Merek::where('merek', $merek)->get()->count() == 0){
					$merek_bool = '0';
				} else {
					$merek_bool = '1';
				}

			//validasi formula jika ada formula dengan komposisi yang sama gagalkan 
				$formula_bool = '0';

				$formulas = Formula::all();
				$temp = [];
				foreach ($formulas as $formula) {
					if($formula->komposisi->count() == count($MyArray)){
						foreach ($formula->komposisi as $komposisi) {
							foreach ($MyArray as $array) {
								if($array['generik_id'] . $array['bobot'] == $komposisi->generik_id.$komposisi->bobot){
									$formula_bool = '1';
									$formula_id = $formula->id;
								} else {
									$formula_bool = '0';
									$formula_id = null;
									break;
								}
							}

							if($formula_bool == '1'){
								break;
							} 
						}
						if($formula_bool == '1'){
							if (Input::get('sediaan') == $formula->sediaan) {
								break;
							} else {
								$formula_bool = '0';
							}
						} 
					}
				}

				// return $formula_id;
				if(isset($formula_id)){
					$temp = DB::table('mereks')
							->leftJoin('raks', 'raks.id', '=', 'mereks.rak_id')
							->where('raks.formula_id', $formula_id)
							->get();
				}
				// return $temp;
				//validasi rak


				if(Rak::where('id', Input::get('rak_id'))->get()->count() == 0){
					$rak = '0';
				} else {
					$rak = '1';
				}

			$data = [
				'merek' 	=> $merek_bool,
				'formula' 	=> $formula_bool,
				'merek1'	=> $merek,
				'rak'		=> $rak,
				'temp' 		=> $temp
			];

			return json_encode($data);

		}

	}

	public function postOnchange(){

		$terapi = Input::get('terapi');
		$periksa_id = Input::get('periksa_id');

		$periksa = Periksa::find($periksa_id);
		$periksa->terapi = $terapi;
		$confirm = $periksa->save();

		if ($confirm) {
			return '1';
		} else {
			return '0';
		}
	}

}

