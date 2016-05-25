<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;
use App\Merek;
use App\Diagnosa;
use App\Classes\Yoga;
use App\BeratBadan;
use App\Asuransi;
use App\Rak;
use DB;
use App\Terapi;
use App\Tidakdirujuk;
use App\Icd10;
use App\Signa;
use App\AturanMinum;
use App\Komposisi;
use App\Formula;
use App\AntrianPeriksa;

class PoliAjaxController extends Controller
{

	public function ibusafe(){
		$umur = explode(" ", trim(Input::get('umur')))[0];
		$merek_id = Input::get('merek_id');
		$merek = Merek::find($merek_id);

		if (
			($merek->rak->formula_id == '150802011' && $umur == '0') ||
			($merek->rak->formula_id == '150802068' && $umur == '0')
			) {
			return '1';
		} else {
			return '0';
		}
	}

	public function pregsafe(){
		$merek_id = Input::get('merek_id');
		$merek = Merek::find($merek_id);
		$komposisis = $merek->rak->formula->komposisi;
		$sediaan = $merek->rak->formula->sediaan;
		$result = [];

		foreach ($komposisis as $key => $komp) {
			if(
				($sediaan == 'tablet' ||
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
		
		$bb = Input::get('berat_badan');
		$asuransi_id = Input::get('asuransi_id');
		$diagnosa_id = Input::get('diagnosa_id');
		$staf_id = Input::get('staf_id');

		$icd10 = Diagnosa::find($diagnosa_id)->icd10_id;

		$tipe_asuransi = Asuransi::find($asuransi_id)->tipe_asuransi;

        if ($bb < 40 && $bb != '') {
            
            if ($tipe_asuransi == '4' || $tipe_asuransi == '5') {
                $query = "SELECT p.id as periksa_id, REPLACE(p.terapi ,' ', '') as terapih, count(p.id) as jumlah from `periksas` as p join diagnosas as d on d.id = p.diagnosa_id join asuransis as asu on asu.id = p.asuransi_id WHERE (staf_id='{$staf_id}' or staf_id='16' ) and (asu.tipe_asuransi > 3) and p.id in (select periksa_id from terapis) and d.icd10_id = '{$icd10}' and p.berat_badan = '{$bb}' and p.created_at > '0000-00-00 00:00:00'group by terapih order by jumlah desc limit 10";
            } else {
                $query = "SELECT p.id as periksa_id, REPLACE(p.terapi ,' ', '') as terapih, count(p.id) as jumlah from `periksas` as p join diagnosas as d on d.id = p.diagnosa_id join asuransis as asu on asu.id = p.asuransi_id WHERE (staf_id='{$staf_id}' or staf_id='16' ) and asu.tipe_asuransi < 4 and p.id in (select periksa_id from terapis) and d.icd10_id = '{$icd10}' and p.berat_badan = '{$bb}'  and p.created_at > '0000-00-00 00:00:00'group by terapih order by jumlah desc limit 10";
            }

        } else{
            
            $query = "SELECT p.id as periksa_id, REPLACE(p.terapi ,' ', '') as terapih, count(p.id) as jumlah from `periksas` as p join diagnosas as d on d.id = p.diagnosa_id join asuransis as asu on asu.id = p.asuransi_id WHERE (staf_id='{$staf_id}' or staf_id='16' ) and asu.tipe_asuransi < 4 and p.id in (select periksa_id from terapis) and d.icd10_id = '{$icd10}' and (p.berat_badan > 40 or p.berat_badan is null or p.berat_badan = 0)  and p.created_at > '0000-00-00 00:00:00'group by terapih order by jumlah desc limit 10";
        }

		$query = DB::select($query);
        $asuransi = Asuransi::find($asuransi_id);
		foreach ($query as $key => $q) {
			$periksa_id = $q->periksa_id;
			$terapih = $q->terapih;
			$terapih = json_decode($terapih, true);
            $terapi = Terapi::where('periksa_id', $periksa_id)->get(['merek_id', 'signa', 'aturan_minum', 'jumlah']);
            $terapi = json_encode( $terapi );
            $terapi = $this->sesuaikanResep($terapi, $asuransi);
			$terapi = $this->masukLagi($terapi);
			$query[$key]->terapih = $terapih;
			$query[$key]->terapi = $terapi;
		}
		return json_encode($query);
	}


	public function diagcha(){
		$diagnosa_id = Input::get('diagnosa_id');
		$icd10 = Diagnosa::find($diagnosa_id)->icd10_id;
		$tidakdirujuk = Tidakdirujuk::where('icd10_id', $icd10)->get();
		if ($tidakdirujuk->count() > 0) {
			return '1';
		} else {
			return '0';
		}


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

		// return 'insign';

		$signa = str_replace(' ', '', Input::get('signa'));
		$warningSama = '';
		$id = '';
		$temp = '';

		if(count(DB::select("SELECT * FROM signas WHERE replace(signa,' ','') = '" . $signa . "'")) > 0){
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

		if(count(DB::select("SELECT * FROM aturan_minums WHERE replace(aturan_minum,' ','') = '" . $aturan . "'")) > 0){
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

		$merek = Merek::find($merek_id);

		$formula_id = $merek->rak->formula_id;

		$komposisi = Komposisi::where('formula_id', $formula_id)->get();

		foreach ($komposisi as $key => $komp) {
			$komposisis[] = [
				'komposisi' => $komp->generik->generik . ' ' . $komp->bobot,
				'pregnancy_safety_index' => $komp->generik->pregnancy_safety_index
			];
		}


		$formula = Formula::find($formula_id);
		$kontraindikasi = $formula->kontraindikasi;
		$indikasi = $formula->indikasi;
		$efek_samping = $formula->efek_samping;

		$data = [

			'komposisis'     => $komposisis,
			'kontraindikasi' => $kontraindikasi,
			'indikasi'       => $indikasi,
			'efek_samping'   => $efek_samping

		];

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
		$asuransi_id = Input::get('asuransi_id');

		if ($asuransi_id == 32) {
			$ap = AntrianPeriksa::find($antrianperiksa_id);
			$ap->asuransi_id = $asuransi_id;
			$ap->kecelakaan_kerja = 0;
			$ap->save();
		} else {
			$ap = AntrianPeriksa::find($antrianperiksa_id);
		$ap->asuransi_id = $asuransi_id;
			$ap->save();
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
		if($asuransi->id == '32' || $asuransi->tipe_asuransi == '4') { // asuransi_id 32 = BPJS atau tipe_asuransi 4 == flat
			if ($terapis != '' && $terapis != '[]') {
				$terapis = $this->sesuaikanResepYoga($terapis, 'asc');
			}
		} elseif($asuransi->tipe_asuransi == '3'){ //tipe_asuransi 1 = admedika
			if ($terapis != '' && $terapis != '[]') {
				$terapis = $this->sesuaikanResepYoga($terapis, 'desc');
			}
        } else {
			if ($terapis != '' && $terapis != '[]') {
				$terapis = $this->sesuaikanResepPasienUmum($terapis);
			}
        }
		return json_decode( $terapis , true );
	}
    
    private function sesuaikanResepYoga($json, $order){
        $terapis = json_decode($json, true);
        foreach ($terapis as $key => $terapi) {
            $formula_id                  = Merek::find($terapi['merek_id'])->rak->formula_id;
            $rak                         = Rak::where('formula_id', $formula_id)->orderBy('kelas_obat_id', $order)->first();
            $terapis[$key]['merek_id']   = $rak->merek->first()->id;
            $terapis[$key]['rak_id']     = $rak->id;
            $terapis[$key]['merek_obat'] = $rak->merek->first()->merek;
        }
        return json_encode($terapis);
    }
    private function sesuaikanResepPasienUmum($json){
        $terapis = json_decode($json, true);
        foreach ($terapis as $key => $terapi) {
            try {
                $formula_id                  = $terapi['formula_id'];
                $rak                         = Rak::where('formula_id', $formula_id)->where('kelas_obat_id', '2')->first();
                $terapis[$key]['merek_id']   = $rak->merek->first()->id;
                $terapis[$key]['rak_id']     = $rak->id;
                $terapis[$key]['merek_obat'] = $rak->merek->first()->merek;
            } catch (\Exception $e) {

            }
        }
        return json_encode($terapis);
    }
    
    private function masukLagi($terapi){
        //return $terapi;
        foreach ($terapi as $k => $v) {
            $signa = $v['signa'];
            $merek                        = Merek::find($v['merek_id']);
            // return $merek->rak->harga_jual;
            $terapi[$k]['harga_jual_ini'] = $merek->rak->harga_jual;
            $terapi[$k]['merek_obat']     = $merek->merek;
            $terapi[$k]['rak_id']         = $merek->rak_id;
            $terapi[$k]['harga_jual']     = $merek->rak->harga_jual;
            $terapi[$k]['formula_id']     = $merek->rak->formula_id;
            if ($signa == 'Puyer' && $merek->rak_id == 'D7') {
                $terapi[$k]['fornas']         = '1';
            } else {
                $terapi[$k]['fornas']         = (string)$merek->rak->fornas;
            }
        }
        return $terapi;
    }


}
