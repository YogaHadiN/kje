<?php

namespace App\Http\Controllers;
use Input;
use DB;
use Log;
use App\Http\Requests;
use App\Models\Classes\Yoga;
use App\Rules\ExpDateHarusFormatTahunBulan;
use App\Models\Periksa;
use App\Models\Formula;
use App\Models\PengantarPasien;
use App\Models\Antrian;
use App\Models\JurnalUmum;
use App\Models\JenisTarif;
use App\Models\Signa;
use App\Models\Terapi;
use App\Models\TransaksiPeriksa;
use App\Models\Tarif;
use App\Http\Controllers\AntrianPolisController;
use App\Http\Controllers\WablasController;
use App\Models\Pasien;
use App\Models\Perbaikanresep;
use App\Models\Tidakdirujuk;
use App\Models\Merek;
use App\Models\Asuransi;
use App\Models\AntrianApotek;
use App\Models\AntrianKasir;

class KasirBaseController extends Controller
{
	/**
	* @param $dependencies
	*/
    public $antriankasir;
	public function __construct()
	{
		 $this->middleware('prolanisFlagging', ['only' => [
			 'kasir'
		 ]]);
	}
	
	public function kasir($id){
		$periksa = Periksa::with('terapii.merek.rak.formula', 'poli')->where('id', $id)->first();
		if (!AntrianApotek::where('periksa_id', $periksa->id)->exists()) {
			$pesan = Yoga::gagalFlash('Pasien sudah melewati proses apotek, tidak perlu diulangi lagi');
			return redirect()->back()->withPesan($pesan);
		}
		$pasien_id  = $periksa->pasien_id;
		$periksa_id = $periksa->id;
		$terapis    = $periksa->terapii;
		$reseps     = Yoga::masukLagi($terapis);
		$plafon     = 0;
		$biayatotal = 0;
   		if ($periksa->asuransi->tipe_asuransi_id == '4') {
			$plafon = Yoga::dispensingObatBulanIni($periksa->asuransi, [], false, true)['plafon'];
			$plafon_obat_tiap_kali_berobat = Tarif::queryTarif($periksa->asuransi_id,3)->biaya;
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
		if ($periksa->poli->poli != 'Poli Estetika') {
			$biayatotal  = Yoga::rataAtas5000($biayatotal);
		}
		$asuransi_id = $periksa->asuransi_id;
		$pasien      = $periksa->pasien;
		$tindakans   = Tarif::listByAsuransi($periksa->asuransi_id);
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
        $messages = [
            'required' => ':attribute Harus Diisi',
        ];
        $rules = [
            'terapi1' => ['required', new ExpDateHarusFormatTahunBulan],
        ];

        $validator = \Validator::make(Input::all(), $rules, $messages);

        if ($validator->fails())
        {
            return \Redirect::back()->withErrors($validator)->withInput();
        }

		$periksa_id            = Input::get('periksa_id');
		$prx                   = Periksa::find($periksa_id);
		$prx->jam_selesai_obat = date('H:i:s');
		$prx->save();

		$antrianapotek = AntrianApotek::where('periksa_id', $periksa_id)->first();

		if ( is_null($antrianapotek)) {
			$pesan = Yoga::gagalFlash('Antrian apotek sudah diproses sebelumnya');
			return redirect()->back()->withPesan($pesan);
		}

		DB::beginTransaction();
		try {
			$terapi1        = Input::get('terapi1');
			$terapi1        = json_decode($terapi1, true);
			$array          = [];
			$hargaObat = 0;
			foreach ($terapi1 as $t) {
				Terapi::where('id', $t['id'])->update([
					'merek_id'          => $t['merek_id'],
					'jumlah'            => $t['jumlah'],
					'exp_date'          => convertToDatabaseFriendlyDateFormatFromBulanTahun( $t['exp_date'] ) ,
					'harga_beli_satuan' => $t['harga_beli_satuan'],
					'harga_jual_satuan' => $t['harga_jual_satuan']
				]);
				$hargaObat += $t['harga_jual_satuan'] * $t['jumlah'];
                $formula_id = $t['merek']['rak']['formula_id'];
                $formula = Formula::find($formula_id);
                $formula->cunam_id = $t['cunam_id'];
                $formula->save();
			}
            //
			//rubah harga obat sesuai dengan terapi yang sudah diubah
			//
			//
			if ($prx->poli->poli != 'Poli Estetika') {
				$hargaObat = Yoga::rataAtas5000( $hargaObat );
			}

			$transaksi = $prx->transaksi;
			$transaksi = json_decode($transaksi, true);

			foreach ($transaksi as $k=> $tr) {
				if ($tr['jenis_tarif'] == 'Biaya Obat') {
					$transaksi[$k]['biaya'] = $hargaObat;
				}
			}

			$prx->transaksi    = json_encode( $transaksi );
			$prx->save();
            $jt_biaya_obat = JenisTarif::where('jenis_tarif', 'Biaya Obat')->first();

            TransaksiPeriksa::where('periksa_id', $prx->id)
                            ->where('jenis_tarif_id', $jt_biaya_obat->id)
                            ->update([
                                'biaya' => $hargaObat
                            ]);

            if ( 
                ( Input::get('tacc') ) 
                && Input::get('tacc') == '1' 
            ) {
				$rjk                    = $prx->rujukan;
				$rjk->time              = Input::get('time_tacc') ;
				$rjk->age               = Input::get('age_tacc') ;
				$rjk->complication      = Input::get('complication_tacc') ;
				$rjk->comorbidity       = Input::get('comorbidity_tacc') ;
				$rjk->tacc              = 1;
				$rjk->save();

				$tidakdirujuk           = Tidakdirujuk::firstOrNew(['icd10_id' => $prx->diagnosa->icd10_id]);
				$tidakdirujuk->diagnosa = $prx->diagnosa->diagnosa ;
				$tidakdirujuk->save();
			}
			//jika ada perbaikan terapi di apotek, masukkam ke dalam database
			if (!empty(Input::get('terapi2'))) {
				$perbaikan             = new Perbaikanresep;
				$perbaikan->periksa_id = $periksa_id;
				$perbaikan->terapi     = Input::get('terapi1');
				$perbaikan->save();
			}

            $statement = DB::select("SHOW TABLE STATUS LIKE 'antrian_kasirs'");
            $next_antrian_kasir_id = $statement[0]->Auto_increment;

			Antrian::where('antriable_type', 'App\Models\AntrianApotek')
					->where('antriable_id', $antrianapotek->id)
					->update([
						'antriable_type' => 'App\Models\AntrianKasir',
						'antriable_id' => $next_antrian_kasir_id
					]);
			PengantarPasien::where('antarable_type', 'App\Models\AntrianApotek')
					->where('antarable_id', $antrianapotek->id)
					->update([
						'antarable_type' => 'App\Models\AntrianKasir',
						'antarable_id'   => $next_antrian_kasir_id
					]);

			$this->antriankasir                              = new AntrianKasir;
			$this->antriankasir->periksa_id                  = $periksa_id;
			$this->antriankasir->jam                         = date('H:i:s');
			$this->antriankasir->tanggal                     = date('Y-m-d');
			$this->antriankasir->memilih_obat_paten          = $antrianapotek->memilih_obat_paten;
			$this->antriankasir->alergi_obat                 = $antrianapotek->alergi_obat;
			$this->antriankasir->previous_complaint_resolved = $antrianapotek->previous_complaint_resolved;
			$this->antriankasir->save();

			$antrianapotek->delete();
			$apc = new AntrianPolisController;
			$apc->updateJumlahAntrian(false, null);

			DB::commit();
			return redirect('antrianapoteks')
				->with('pesan', Yoga::suksesFlash('Resep pasien periksa ' . $prx->id. ' <strong>' . $prx->pasien->id . ' - ' . $prx->pasien->nama . '</strong> telah dicetak'))
				->with('kasir_submit', $periksa_id);

		} catch (\Exception $e) {
			DB::rollback();
			throw $e;
		}
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
			if ($periksa->asuransi->tipe_asuransi_id == 5) {
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
		if ($periksa->poli->poli != 'Poli Estetika') {
			$harga_obat = Yoga::rataAtas5000($harga_obat);
		}
		// return $harga_obat;
		$transaksis = json_decode($periksa->transaksi, true);

		if ($periksa->asuransi->tipe_asuransi_id != '4') {
			foreach ($transaksis as $k => $trx) {
				if ($trx['jenis_tarif'] == "Biaya Obat") {
					if ($harga_obat < 30000 && ( 
						$periksa->asuransi_id == '101' ||  // cibadan broiler
						$periksa->asuransi_id == '92'  // cibadak feedmill
					)) {
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

    public function getExpDates(){
        $rak_id = Input::get('rak_id');
        $tenant_id = session()->get('tenant_id');
        $query  = "SELECT ";
        $query .= "DATE_FORMAT(trp.exp_date, \"%Y-%m\") as exp_date ";
        $query .= "FROM terapis as trp ";
        $query .= "JOIN mereks as mrk on mrk.id = trp.merek_id ";
        $query .= "WHERE mrk.rak_id = {$rak_id} ";
        $query .= "AND trp.exp_date is not null ";
        $query .= "AND trp.tenant_id = {$tenant_id} ";
        $query .= "group by trp.exp_date ";
        $query .= "order by trp.exp_date desc";
        $data = DB::select($query);

        $exp_dates = [];
        foreach ($data as $d) {
            $exp_dates[] = $d->exp_date;
        }

        $query  = "SELECT ";
        $query .= "DATE_FORMAT(pmb.exp_date, \"%Y-%m\") as exp_date ";
        $query .= "FROM pembelians as pmb ";
        $query .= "JOIN mereks as mrk on mrk.id = pmb.merek_id ";
        $query .= "WHERE mrk.rak_id = {$rak_id} ";
        $query .= "AND pmb.exp_date > now() ";
        $query .= "AND pmb.tenant_id = {$tenant_id} ";
        $query .= "AND pmb.exp_date is not null ";
        $query .= "group by pmb.exp_date ";
        $query .= "order by pmb.exp_date desc";
        $data = DB::select($query);

        foreach ($data as $d) {
            $exp_dates[] = $d->exp_date;
        }
        return array_values(array_unique($exp_dates));
    }
    /**
     * undocumented function
     *
     * @return void
     */

    private function infokanPasienBahwaObatSelesaiDiracik()
    {
        if (
             !is_null( $this->antriankasir->antrian ) &&
             $this->antriankasir->antrian->notifikasi_panggilan_aktif &&
             !empty( $this->antriankasir->antrian->no_telp ) &&
             count( json_decode( $this->antriankasir->periksa->terapi , true) ) > 0
        ) {
            $message = 'Obat pasien atas nama :';
            $message .= PHP_EOL;
            $message .= PHP_EOL;
            $message .= '*' . ucwords($this->antriankasir->periksa->pasien->nama) .'* ';
            $message .= PHP_EOL;
            $message .= PHP_EOL;
            $message .= 'Sudah selesai diracik.';
            $message .= PHP_EOL;
            if (  $this->antriankasir->antrian->menunggu  ) {
                $message .= 'Dan saat ini sedang dalam antrian untuk penjelasan obat. Mohon tunggu untuk dipanggil';
            } else {
                $message .= 'Kakak dapat mengambil obat tersebut di ruang farmasi.';
            }

            resetWhatsappRegistration( $this->antriankasir->antrian->no_telp );

            $wablas = new WablasController;
            $wablas->sendSingle($this->antriankasir->antrian->no_telp, $message);
        }
    }
    
    
}
