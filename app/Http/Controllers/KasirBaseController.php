<?php

namespace App\Http\Controllers;
use Input;
use App\Http\Requests;
use App\Classes\Yoga;
use App\Periksa;
use App\Signa;
use App\Terapi;
use App\Tarif;
use App\Pasien;
use App\Perbaikanresep;
use App\Tidakdirujuk;
use App\Merek;
use App\Asuransi;

class KasirBaseController extends Controller
{
	public function kasir($id){



        $periksa = Periksa::with('terapii.merek.rak.formula')->where('id', $id)->first();
		if ( $periksa->lewat_kasir == '1' ) {
			$pesan = Yoga::gagalFlash('Pasien sudah melewati proses apotek, tidak perlu diulangi lagi');
			return redirect()->back()->withPesan($pesan);
		}
		$pasien_id  = $periksa->pasien_id;
		$periksa_id = $periksa->id;
		$terapis    = $periksa->terapii;
		$reseps     = Yoga::masukLagi($terapis);
		$plafon     = 0;
		$biayatotal = 0;
   		if ($periksa->asuransi->tipe_asuransi == '4') {
			$plafon = Yoga::dispensingObatBulanIni($periksa->asuransi, [], false, true)['plafon'];
			$plafon_obat_tiap_kali_berobat = Tarif::where('asuransi_id', $periksa->asuransi_id)->where('jenis_tarif_id', '9')->first()->biaya;
			if ($plafon >= 0) {
			   $biayatotal = $plafon_obat_tiap_kali_berobat;				
   			} else {
   				$biayatotal = $plafon_obat_tiap_kali_berobat -$plafon;
   			}
   		} else {
   			$terapiss = Yoga::masukLagi($terapis);
			foreach ($terapiss as $key => $terapi) {
				$biayatotal += Yoga::kasirHargaJualItem($terapi, $periksa, false);
			}
   		}
		$biayatotal  = Yoga::rataAtas5000($biayatotal);
		$asuransi_id = $periksa->asuransi_id;
		$pasien      = $periksa->pasien;
		$tindakans   = [ null => '- Pilih -' ] + Tarif::where('asuransi_id', $asuransi_id)->with('jenisTarif')->get()->lists('jenis_tarif_list', 'tarif_jual')->all();
		$transaksi   = $periksa->transaksi;
		$resepjson   = json_encode($reseps);
		//	HITUNG DISPENSING BULAN INI KHUSUS UNTUK TIPE ASURANSI FLAT
		$plafonFlat  = Yoga::dispensingObatBulanIni($periksa->asuransi, true);
		$mereks      = Merek::with('rak.formula')->get();
		return view('kasir')
			->withPasien($pasien)
			->withPlafon($plafon)
			->withReseps($reseps)
			->withTerapis($terapis)
			->withResepjson($resepjson)
			->withTindakans($tindakans)
			->withMereks($mereks)
			->withBiayatotal($biayatotal)
			->withTransaksi($transaksi)
			->withPeriksa($periksa);
	}

	public function onchange(){

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


	public function kasir_submit(){

		$periksa_id = Input::get('periksa_id');
		$merek      = Merek::all();

		$prx = Periksa::find($periksa_id);

		if ( $prx->lewat_kasir == '1' ) {
			$pesan = Yoga::gagalFlash('Pasien sudah melewati proses apotek, tidak perlu diulangi lagi');
			return redirect('antriankasirs')->withPesan($pesan);
		}

		$prx->lewat_kasir = '1';
		$prx->save();

		if ( ( Input::get('tacc') ) && Input::get('tacc') == '1' ) {
			$rjk       = $prx->rujukan;
			$rjk->time   = Input::get('time_tacc') ;
			$rjk->age   = Input::get('age_tacc') ;
			$rjk->complication   = Input::get('complication_tacc') ;
			$rjk->comorbidity   = Input::get('comorbidity_tacc') ;
			$rjk->tacc   = 1;
			$rjk->save();


			$tidakdirujuk             = Tidakdirujuk::firstOrNew(['icd10_id' => $prx->diagnosa->icd10_id]);
			$tidakdirujuk->diagnosa   = $prx->diagnosa->diagnosa ;
			$tidakdirujuk->save();
		}


        if (!empty(Input::get('terapi2'))) {
            $perbaikan = new Perbaikanresep;
            $perbaikan->periksa_id = $periksa_id;
            $perbaikan->terapi = Input::get('terapi1');
            $perbaikan->save();
        }

		return redirect('antriankasirs')->with('pesan', Yoga::suksesFlash('Resep pasien periksa ' . $prx->id. ' <strong>' . $prx->pasien->id . ' - ' . $prx->pasien->nama . '</strong> telah dicetak'));

	}

	public function changeMerek(){
		$merek_id    = Input::get('merek_id');
		$asuransi_id = Input::get('asuransi_id');
		$id          = Input::get('id');
		$merek       = Merek::find($merek_id);

		$terapi                    = Terapi::find($id);
		$terapi->merek_id          = $merek->id;
		$terapi->harga_beli_satuan = $merek->rak->harga_beli;
		$terapi->harga_jual_satuan = Yoga::hargaJualSatuan(Asuransi::find($asuransi_id), $merek_id);
		$confirm = $terapi->save();

		$periksa_id = $terapi->periksa_id;

		$prx            = Periksa::find($periksa_id);
		$prx->transaksi = $this->updateTransaksi($prx);
		$prx->save();
		if ($confirm) {
			$submitted = '1';
		} else {
			$submitted = '0';
		}
		return json_encode([
			'confirm' => $submitted,
			'terapi' => Periksa::find($periksa_id)->terapi_html
		]);

	}

	public function updatejumlah(){
		$jumlah = Input::get('jumlah');
		$id = Input::get('id');
		
		$terapi         = Terapi::find($id);
		$formula_id     = Merek::find($terapi->merek_id)->rak->formula_id;
		$terapi->jumlah = $jumlah;
		$confirm        = $terapi->save();
		$periksa_id     = $terapi->periksa_id;

		$periksa            = Periksa::find($periksa_id);
		$periksa->terapi    = $this->terapisSortBaru($periksa);
		$periksa->transaksi = $this->updateTransaksi($periksa);
		$periksa->save();


		if ($confirm) {
			$submitted = '1';
		} else {
			$submitted = '0';
		}

		return json_encode([
			'confirm' => $submitted,
			'terapi'  => Periksa::find($periksa_id)->terapi_html,
			'terapiJson'  => Periksa::find($periksa_id)->terapii
        ]);

	}

	private function updateTransaksi($periksa){
		$terapis = Terapi::where('periksa_id', $periksa->id)->get();
		$harga_obat = 0;

		foreach ($terapis as $k => $terapi) {
			if ($periksa->asuransi_id == '32') {
				$fornas = Merek::find($terapi->merek_id)->rak->fornas;
				if ($fornas == '1') {
					$harga_obat += 0;
				} else {
					$harga_obat += $this->hargaHitung($terapi, $periksa);
				}
			} else {
				$harga_obat += $this->hargaHitung($terapi, $periksa);
			}
		}
		$harga_obat = Yoga::rataAtas5000($harga_obat);
		// return $harga_obat;
		$transaksis = json_decode($periksa->transaksi, true);

		if ($periksa->asuransi->tipe_asuransi != '4') {
			foreach ($transaksis as $k => $trx) {
				if ($trx['jenis_tarif'] == "Biaya Obat") {
                    if ($harga_obat < 30000 && ( $periksa->asuransi_id == '151222001' || $periksa->asuransi_id == '10' )) {
                       $harga_obat = 30000; 
                    }
					$transaksis[$k]['biaya'] = $harga_obat;
				}
			}
		}
		return json_encode($transaksis);
	}

	private function hargaHitung($terapi, $periksa){
		$harga      = $terapi->merek->rak->harga_jual;
		$kali_obat  = $periksa->asuransi->kali_obat;
		$jumlah     = $terapi->jumlah;
		return $harga * $kali_obat * $jumlah; 
	}

	private function terapisSortBaru($periksa){
		$terapis        = Terapi::where('periksa_id', $periksa->id)->get();
		$terapis_baru   = [];
		foreach ($terapis as $k => $v) {
			$formula_id = $v->merek->rak->formula_id;
			$signa      = $v->signa;
			$jumlah     = $v->jumlah;

			$terapis_baru[] = [
				'formula_id' => $formula_id,
				'signa'      => $signa,
				'jumlah'     => $jumlah,
			];
		}
		array_multisort($terapis_baru);
		return json_encode($terapis_baru);
	}

}
