<?php

namespace App\Http\Controllers;

use Input;
use DB;
use Log;
use App\Http\Requests;
use App\Models\Merek;
use App\Models\Pasien;
use App\Models\Diagnosa;
use App\Models\Classes\Yoga;
use App\Models\BeratBadan;
use App\Models\Asuransi;
use App\Models\Generik;
use App\Models\BahanHabisPakai;
use App\Models\Rak;
use App\Models\Alergi;
use App\Models\Staf;
use App\Models\Terapi;
use App\Models\Tidakdirujuk;
use App\Models\Icd10;
use App\Models\Signa;
use App\Models\AturanMinum;
use App\Models\Komposisi;
use App\Models\Formula;
use App\Models\AntrianPeriksa;
use App\Models\Periksa;
use App\Models\GambarPeriksa;

class PoliAjaxController extends Controller
{

	public function ibusafe(){
		$umur     = explode(" ", trim(Input::get('umur')))[0];
		$merek_id = Input::get('merek_id');
		$merek    = Merek::find($merek_id);
		if ( $this->containsIbuprofen($merek) && $umur < 1 ) {
			return '1';
		} else {
			return '0';
		}
	}

	public function pregsafe(){
		$merek_id   = Input::get('merek_id');
        $merek      = Merek::with('rak.formula.komposisi', 'rak.formula.sediaan')
                            ->where('id', $merek_id)
                            ->first();
		$komposisis = $merek->rak->formula->komposisi;
		$sediaan    = $merek->rak->formula->sediaan->sediaan;
		$result     = [];

		foreach ($komposisis as $key => $komp) {
			if(
                (
                    $sediaan == 'tablet' ||
                    $sediaan == 'capsul' ||
                    $sediaan == 'syrup') && (
                    $komp->generik->peroral != 'a' &&
                    $komp->generik->peroral != 'b'
				)
			) {
				foreach ($komposisis as $key => $komps) {
					$result[] = [
						'generik' => $komps->generik->generik,
						'bobot' => $komps->bobot,
						'pregnancy_safety_index' => $komps->generik->pregnancy_safety_index
					];
				}
				return json_encode($result);
			}
		}
	}

	public function sopterapi(){
		$bb = input::get('berat_badan');
        $bb = (int)$bb;
        if (empty( $bb )) {
            $bb = '';
        }
        $asuransi_id           = input::get('asuransi_id');
        $pasien_id             = input::get('pasien_id');
        $diagnosa_id           = input::get('diagnosa_id');
        $staf_id               = input::get('staf_id');
        $icd10                 = Diagnosa::find($diagnosa_id)->icd10_id;
        $asuransi              = Asuransi::find($asuransi_id);
        $tipe_asuransi_id      = $asuransi->tipe_asuransi_id;
        $parameter_asuransi    = '';
        $parameter_berat_badan = '';

        if ($tipe_asuransi_id > 3) {
            $parameter_asuransi = "(asu.tipe_asuransi_id > 3)";
        } else {
            $parameter_asuransi = "(asu.tipe_asuransi_id < 4)";
        }

		$alergies    = Alergi::where('pasien_id', $pasien_id)->get();

		$generik_ids = [];
		foreach ($alergies as $alergi) {
			$generik_ids[] = $alergi->generik_id;
		}

		$komposisis_alergi = Komposisi::whereIn('generik_id', $generik_ids)->get();

		$formula_ids = [];

		foreach ($komposisis_alergi as $komposisi) {
			$formula_ids[] = $komposisi->formula_id;
		}

		$merek_discontinue = Merek::with('rak')->where('discontinue', 1)->get();
		foreach ($merek_discontinue as $md) {
			$formula_ids[] = $md->rak->formula_id;
		}

        //jika dibawah 25 kg, maka query di setiap kilo tanpa range diatas itu pakai range  
        if ($bb < 18 && $bb != '') {
           $parameter_berat_badan = "( p.berat_badan = '{$bb}' )";
        }else if ($bb > 17 && $bb < 24 && $bb != ''){
           $parameter_berat_badan = "(p.berat_badan > 17 and p.berat_badan < 24)";
        }else if ($bb > 23 && $bb < 28 && $bb != ''){
           $parameter_berat_badan = "(p.berat_badan > 23 and p.berat_badan < 28)";
        }else if ($bb > 27 && $bb < 36 && $bb != ''){
           $parameter_berat_badan = "(p.berat_badan > 27 and p.berat_badan < 36)";
        }else if ($bb > 35 && $bb < 41 && $bb != ''){
           $parameter_berat_badan = "(p.berat_badan > 35 and p.berat_badan < 41)";
        } else{
           $parameter_berat_badan = "(p.berat_badan > 40 or p.berat_badan is null or p.berat_badan = 0)";
        }

		$query  = "select p.id as periksa_id, ";
		$query .= "replace(p.terapi ,' ', '') as terapih, ";
		$query .= "count(p.id) as jumlah ";
		$query .= "from `periksas` as p ";
		$query .= "join diagnosas as d on d.id = p.diagnosa_id ";
		$query .= "join asuransis as asu on asu.id = p.asuransi_id ";
		$query .= "join terapis as trp on trp.periksa_id = p.id ";
		$query .= "join mereks as mrk on mrk.id = trp.merek_id ";
		$query .= "join raks as rk on rk.id = mrk.rak_id ";
        $query .= "where ";
        if ( session()->get('tenant_id') == 1 ) {
            if ( 
                 $asuransi->tipe_asuransi_id != 5
            ) {
                $query .= "( ";
                $query .= "staf_id= {$staf_id} or ";
                $query .= "staf_id=" . Staf::owner()->id;
                $query .= " ) AND "; 
            } else {
                $query .= "staf_id=" . Staf::owner()->id;
                $query .= " AND "; 
            }
        } else {
            $query .= "( ";
            $query .= "staf_id= {$staf_id} or ";
            $query .= "staf_id=" . Staf::owner()->id;
            $query .= " ) AND "; 
        }

		$query .= "p.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and {$parameter_asuransi} ";
		$query .= "and d.icd10_id = '{$icd10}' ";
		$query .= "and {$parameter_berat_badan} ";
		foreach ($formula_ids as $formula_id) {
			$query .= "and rk.formula_id not like {$formula_id} ";
		}
		$query .= "and p.created_at > '2016-01-22 18:15:04' ";
		$query .= "group by terapih ";
		$query .= "order by jumlah ";
		$query .= "desc limit 10;";

		$query =  DB::select($query);

		if (count($query)) {
			$periksa_ids = [];
			foreach ($query as $q) {
				$periksa_ids[] = $q->periksa_id;
			}

			$terapi_terapi = Terapi::with('merek.rak.formula.rak.merek')->whereIn('periksa_id', $periksa_ids)->get(['merek_id', 'signa', 'aturan_minum', 'jumlah', 'periksa_id']);

			$array = [];
			foreach ($terapi_terapi as $t) {
				$array[$t->periksa_id][] = $t;
			}

			foreach ($query as $key => $q) {
				$periksa_id = $q->periksa_id;
				if (isset($array[$periksa_id])) {
					$terapi  = $array[$periksa_id];
					$terapi  = $this->sesuaikanResep($terapi, $asuransi);
					$terapi  = $this->masukLagi($terapi, $asuransi);
					$terapih = $q->terapih;
					$terapih = json_decode($terapih, true);

					$query[$key]->terapih = $terapih;
					$query[$key]->terapi = $terapi;
				}
			}
			return json_encode($query);
        } else {
			return json_encode([]);
        }
	}
	public function diagcha(){
		$diagnosa_id         = Input::get('diagnosa_id');
		$pasien_id           = Input::get('pasien_id');
		$icd10               = Diagnosa::find($diagnosa_id)->icd10_id;
		$tidakdirujuk        = Tidakdirujuk::where('icd10_id', $icd10)->get();
		$ganti_diagnosa      = 0;
		$tidak_boleh_dirujuk = 0;

		$pasien = Pasien::find( $pasien_id );

		if (
			(strpos($icd10, 'I1') !== false && !$pasien->prolanis_ht) || //jika diagnosa merupakan diagnosa hipertensi
			(strpos($icd10, 'E1') !== false && !$pasien->prolanis_dm)
		) {
			$ganti_diagnosa = 1;
		}

		if ($tidakdirujuk->count() > 0) {
			$tidak_boleh_dirujuk = 1;
		} 

		return compact(
			'tidak_boleh_dirujuk', 'ganti_diagnosa'
		);
	}

	public function indiag(){

		$icd10 = Input::get('icd10');
		$diagnosa = Input::get('diagnosa');

		if(Diagnosa::where('diagnosa', $diagnosa)->get()->count() > 0){
			return '01';
		}

		$diag           = new Diagnosa;
		$diag->icd10_id = $icd10;
		$diag->diagnosa = $diagnosa;
		$confirm        = $diag->save();

		if ($confirm) {
			\Cache::forget('diagnosa');
		}

		$id = $diag->id;

		$diagnosaICD = Icd10::find($icd10)->diagnosaICD;

		if($id){
			$data = [
				'id' => $id,
				'diagnosaICD' => $diagnosaICD,
				'diagnosa' => $diagnosa
			];
			return json_encode($data);
		} else {
			return '0';
		}
		
	}

	public function insigna(){

		$signa       = str_replace(' ', '', Input::get('signa'));
		$warningSama = '';
		$id          = '';
		$temp        = '';

		$query  = "SELECT * ";
		$query .= "FROM signas ";
		$query .= "WHERE replace(signa,' ','') = '" . $signa . "';";
		if(count(DB::select($query)) > 0){
			$warningSama = 'Signa ini sudah ada';
		} else {
			$sig = new Signa;
			$sig->signa = Input::get('signa');
			$confirm = $sig->save();

			if ($confirm) {
				\Cache::forget('signa');
			}
			$id = $sig->id;

		}

		$data = [
			'warning' 	=> $warningSama,
			'id'		=> $id,
			'temp'		=> Signa::latest()->first()
		];

		return json_encode($data);

	}

	public function selectsigna(){
		$signa = Input::get('signa');
		return json_encode(Signa::where('signa', 'like', '%' . $signa . '%')->take(10)->get());
	}
	public function selectatur(){
		$aturan = Input::get('aturan');
		return json_encode(AturanMinum::where('aturan_minum', 'like', '%' . $aturan . '%')->take(10)->get());
	}


	public function inatur(){
		$aturan = str_replace(' ', '', Input::get('aturan'));
		$warningSama = '';
		$id = '';
		$temp = '';

		$query = "SELECT * ";
		$query .= "FROM aturan_minums ";
		$query .= "WHERE replace(aturan_minum,' ','') = '" . $aturan . "'";
		if(count(DB::select($query)) > 0){
			$warningSama = 'Aturan Minum ini sudah ada';
		} else {
			$atu = new AturanMinum;
			$atu->aturan_minum = Input::get('aturan');
			$confirm = $atu->save();
			if ($confirm) {
				\Cache::forget('aturanList');
			}
			$id = $atu->id;
		}
		$data = [
			'warning' 	=> $warningSama,
			'id'		=> $id,
			'temp'		=> AturanMinum::latest()->first()
		];
		return json_encode($data);
	}

	public function ajxobat(){
		$merek_id = Input::get('merek_id');
		$merek      = Merek::with('rak.formula.komposisi')->where('id',$merek_id)->first();
		if ( !is_null($merek)) {
			$komposisi  = $merek->rak->formula->komposisi;
			$komposisis = [];
			foreach ($komposisi as $key => $komp) {
				$komposisis[] = [
					'komposisi'              => $komp->generik->generik . ' ' . $komp->bobot,
					'pregnancy_safety_index' => $komp->generik->pregnancy_safety_index
				];
			}
			$formula        = $merek->rak->formula;
			$kontraindikasi = $formula->kontraindikasi;
			$indikasi       = $formula->indikasi;
			$efek_samping   = $formula->efek_samping;

			$data = [
				'komposisis'     => $komposisis,
				'kontraindikasi' => $kontraindikasi,
				'indikasi'       => $indikasi,
				'efek_samping'   => $efek_samping

			];
		} else {

			$data = [
				'komposisis'     => [],
				'kontraindikasi' => null,
				'indikasi'       => null,
				'efek_samping'   => null
			];

			Log::info('=============================================');
			Log::info('=============================================');
			Log::info('');
			Log::info('Tidak ditemukan merek dengan id ' . $merek_id);
			Log::info('');
			Log::info('=============================================');
			Log::info('=============================================');
		}
		return json_encode($data);
	}


	public function diag(){

		$id = Input::get('icd10');

		$data = Diagnosa::where('icd10_id', $id)->select('id', 'diagnosa')->get();

		return json_encode($data);
		
	}

	public function pilih(){

		$byICD = trim(Input::get('byICD'));
		$byDiagnosa = trim(Input::get('byDiagnosa'));

		$byICDlist = explode(' ', $byICD);
		$byDiagnosaList = explode(' ', $byDiagnosa);

		if(!empty($byDiagnosa) || !empty($byICD)){

			$query = "SELECT * FROM icd10s WHERE ";
			if(!empty($byDiagnosa)) {
				$query .= "(diagnosaICD like '%" . $byDiagnosaList[0] . "%')";
				for ($i = 1; $i < count($byDiagnosaList); $i++) {
					$query .= " AND (diagnosaICD like '%" . $byDiagnosaList[$i] . "%')";
				}
			}
			if (!empty($byICD) && empty($byDiagnosa)) {
				$query .= "(id like '%" . $byICDlist[0] . "%')";
				for ($i = 1; $i < count($byICDlist); $i++) {
					$query .= " AND (id like '%" . $byICDlist[$i] . "%')";
				}
			} else if (!empty($byICD) && !empty($byDiagnosa)) {
				$query .= " AND (id like '%" . $byICDlist[0] . "%')";
				for ($i = 1; $i < count($byICDlist); $i++) {
					$query .= " AND (id like '%" . $byICDlist[$i] . "%')";
				}
			}

		} else {
			$query = "SELECT * FROM icd10s";
		}

		$query .= " LIMIT 10";
		
		return DB::select($query);

	}

	public function kkchange(){
		$antrianperiksa_id    = Input::get('antrianperiksa_id');
		$ap                   = AntrianPeriksa::find($antrianperiksa_id);
		$ap->asuransi_id      = 0;
		$ap->kecelakaan_kerja = 1;
		$ap->keterangan       = 'Pasien bayar tunai, karena BPJS tidak menanggung kecelakaan kerja / kecelakaan lalu lintas';
		$ap->save();
	}
	public function asuridchange(){
		$antrianperiksa_id = Input::get('antrianperiksa_id');
		$asuransi_id       = Input::get('asuransi_id');
        $periksa = Periksa::where('antrian_periksa_id', $antrianperiksa_id)->first();
        if (!is_null($periksa)) {
            if ($periksa->lewat_kasir2 == '1' ) {
                $pesan = Yoga::gagalFlash('Pasien sudah selesai / sudah pulang tidak bisa diedit');
                return redirect()->back()->withPesan($pesan);
            } else if ($periksa->lewat_kasir == '1') {
                $pesan = Yoga::gagalFlash('Pasien sudah dicetak statusnya, hubungi staf untuk mengembalikan dulu ke antrian periksa untuk merubah');
                return redirect()->back()->withPesan($pesan);
            }
        }

		if (Asuransi::find($asuransi_id)->tipe_asuransi_id == 5) {
            $ap                   = AntrianPeriksa::findOrFail($antrianperiksa_id);
            if (!is_null($ap)) {
                $ap->asuransi_id      = $asuransi_id;
                $ap->kecelakaan_kerja = 0;
                $ap->save();
            } else {
                $pesan = Yoga::gagalFlash('Antrian Periksa Sudah Tidak Ditemukan, Hubungi Staf untuk kembalikan ke antrian periksa');
                return redirect()->back()->withPesan($pesan);
            }
		} else {
            $ap              = AntrianPeriksa::findOrFail($antrianperiksa_id);
            if (!is_null($ap)) {
				$ap->asuransi_id = $asuransi_id;
				$ap->save();
            } else {
				$pesan = Yoga::gagalFlash('Antrian Periksa Sudah Tidak Ditemukan, Hubungi Staf untuk kembalikan ke antrian periksa');
				return redirect()->back()->withPesan($pesan);
            }
		}
	}
	public function asuridchange2(){
		$antrianperiksa_id = Input::get('antrianperiksa_id');
		$asuransi_id       = Input::get('asuransi_id');
		$ap                = AntrianPeriksa::find($antrianperiksa_id);
		$ap->asuransi_id   = $asuransi_id;
		$ap->keterangan    = 'Pasien bayar tunai, karena BPJS tidak menanggung kecelakaan kerja / kecelakaan lalu lintas';
		$ap->save();
	}


	private function sesuaikanResep($terapis, $asuransi){
		if($asuransi->tipe_asuransi_id ==  5 || $asuransi->tipe_asuransi_id == '4') { // asuransi_id 32 = BPJS atau tipe_asuransi 4 == flat
			if ($terapis != '' && $terapis != '[]') {
				$terapis = $this->sesuaikanResepYoga($terapis, 'asc');
			}
		} elseif($asuransi->tipe_asuransi_id == '3'){ //tipe_asuransi 1 = admedika
			if ($terapis != '' && $terapis != '[]') {
				$terapis = $this->sesuaikanResepYoga($terapis, 'desc');
			}
        } else {
			if ($terapis != '' && $terapis != '[]') {
				$terapis = $this->sesuaikanResepPasienUmum($terapis);
			}
        }
		return $terapis;
	}
    
    private function sesuaikanResepYoga($terapis, $order){
        foreach ($terapis as $key => $terapi) {
            $rak                  = $terapi->merek->rak->formula->rak;
			$rak					= $rak->sortBy('kelas_obat_id')->first();
            $terapis[$key]['merek_id']   = $rak->merek->first()->id;
            $terapis[$key]['rak_id']     = $rak->id;
            $terapis[$key]['merek_obat'] = $rak->merek->first()->merek;
        }
        return $terapis;
    }
    private function sesuaikanResepPasienUmum($terapis){
        foreach ($terapis as $key => $terapi) {
			$rak                         = $terapi->merek->rak->formula->rak;
			$array = [];
			foreach ($rak as $r) {
				$array[$r->kelas_obat_id] = $r;
			}
			if (isset($array[2])) {
				$rak = $array[2];
				$terapis[$key]['merek_id']   = $rak->merek->first()->id;
				$terapis[$key]['rak_id']     = $rak->id;
				$terapis[$key]['merek_obat'] = $rak->merek->first()->merek;
			}
        }
        return $terapis;
    }
    
    private function masukLagi($terapis, $asuransi){
        //return $terapi;
        $khususBpjs = [];
        $is_bpjs =  $asuransi->tipe_asuransi_id == 5;
        if ($is_bpjs) {
            $raks = Rak::orderBy('kelas_obat_id', 'desc')->get();
            foreach ($raks as $r) {
                $khususBpjs[$r->formula_id] = $r;
            }
        }
        foreach ($terapis as $k => $terapi) {
            // return $merek->rak->harga_jual;
            $terapis[$k]['merek_obat']     = $is_bpjs?$terapi->merek->merek . " (".rupiah($khususBpjs[ $terapi->merek->rak->formula_id ]->harga_beli  ).")": $terapi->merek->merek;
            $terapis[$k]['rak_id']         = $terapi->merek->rak_id;
            $terapis[$k]['harga_jual_ini'] = $is_bpjs ? $khususBpjs[ $terapi->merek->rak->formula_id ]->harga_jual : $terapi->merek->rak->harga_jual;
            $terapis[$k]['harga_jual']     = $is_bpjs ? $khususBpjs[ $terapi->merek->rak->formula_id ]->harga_jual : $terapi->merek->rak->harga_jual;
            $terapis[$k]['harga_beli']     = $is_bpjs ? $khususBpjs[ $terapi->merek->rak->formula_id ]->harga_beli : $terapi->merek->rak->harga_beli;
            $terapis[$k]['harga_beli_satuan'] = $is_bpjs ? $khususBpjs[ $terapi->merek->rak->formula_id ]->harga_beli : $terapi->merek->rak->harga_beli;
            $terapis[$k]['formula_id']     = $terapi->merek->rak->formula_id;
            if ($terapi->signa == 'Puyer' && $terapi->merek->rak_id == 'D7') {
                $terapis[$k]['fornas']         = '1';
            } else {
                $terapis[$k]['fornas']         = (string)$terapi->merek->rak->fornas;
            }
        }
        return $terapis;
    }
    public function bhp_tindakan(){
         $jsonData = Input::get('jsonData');
         $jsonData = json_decode($jsonData, true);
         $bahan_habis_pakais = [];

         foreach ($jsonData as $data) {
             $jenis_tarif_id = $data['jenis_tarif_id'];
             $bhps = BahanHabisPakai::where('jenis_tarif_id', $jenis_tarif_id)->get();
             foreach ($bhps as $bhp) {
                 $sama = false;
                 if (count($bahan_habis_pakais) > 0) {
                     foreach ($bahan_habis_pakais as $k=>$b) {
                         if ($b['merek_id'] == $bhp['merek_id']) {
                            $bahan_habis_pakais[$k]['jumlah'] = $b['jumlah'] + $bhp['jumlah']; 
                            $sama = true;
                            break;
                         }
                     }
                 }
                 if (!$sama) {
                     $bahan_habis_pakais[] = [
                         'merek_id' => $bhp['merek_id'],
                         'merek' => Merek::find($bhp['merek_id'])->merek,
                         'jumlah' => $bhp['jumlah']
                     ];
                 }
             }
         }
         return json_encode($bahan_habis_pakais);
    }
	public function ambil_gambar(){
		$antrianperiksa_id = Input::get('antrianperiksa_id');
		$gambar = GambarPeriksa::where('gambarable_type', 'App\Models\AntrianPeriksa')->where('gambarable_id', $antrianperiksa_id)->get();
		$data = [];
		foreach ($gambar as $g) {
			$data[] = [
				'image' => $g->nama,
				'keterangan' => $g->keterangan
			];
		}
		return json_encode($data);
	}
	public function alergiPost($id){
		$pasien_id  = Input::get('pasien_id');
		$generik_id = Input::get('generik_id');

		$data = [];
		if(!Alergi::where('pasien_id', $pasien_id)->where('generik_id', $generik_id)->count()){
			$alergi             = new Alergi;
			$alergi->pasien_id  = Input::get('pasien_id');
			$alergi->generik_id = Input::get('generik_id');
			$alergi->save();
			$data['valid'] = 1;
		} else {
			$data['valid'] = 0;
		}

		$alergies = Alergi::where('pasien_id', $pasien_id)->get();
		foreach ($alergies as $alg) {
			$data['alergi'][] = [
				'id'      => $alg->id,
				'generik' => $alg->generik->generik
			];
		}
		return $data;
	}
	public function alergiDelete(){
		$alergi_id = Input::get('alergi_id');
		$pasien_id = Input::get('pasien_id');

		Alergi::destroy( $alergi_id );
		
		$alergies = Alergi::where('pasien_id', $pasien_id)->get();
		$data = [];
		foreach ($alergies as $alg) {
			$data[] = [
				'id' => $alg->id,
				'generik' => $alg->generik->generik
			];
		}
		return $data;
	}
	public function alergiPrevent(){
		$pasien_id = Input::get('pasien_id');
		$merek_id  = Input::get('merek_id');


		$alergies = Alergi::where('pasien_id', $pasien_id)
							->get(['generik_id']);
		if ( !$alergies->count() ) {
			return '0';
		}

		$generik_ids = [];
		foreach ($alergies as $alergi) {
			$generik_ids[] = $alergi->generik_id;
		}

		$formula_id   = Merek::find($merek_id)->rak->formula_id;
		return Komposisi::where('formula_id', $formula_id)->whereIn('generik_id', $generik_ids)->count() ;
	}
    public function getTipeAsuransiId(){
        $asuransi_id = Input::get('asuransi_id');

        return Asuransi::find($asuransi_id)->tipe_asuransi_id;
        
    }
    /**
     * undocumented function
     *
     * @return void
     */
    private function containsIbuprofen($merek)
    {
        foreach ($merek->rak->formula->komposisi as $komposisi) {
            if ( $komposisi->generik_id == '544' ) {
                return true;
            }
        }
        return false;

    }
    
    
}
