<?php

namespace App\Http\Controllers;

use Input;
use App\Http\Requests;
use App\Models\Asuransi;
use App\Models\Rak;
use App\Models\Yoga;
use App\Models\Dose;
use App\Models\BeratBadan;
use DB;

class DdlMerekController extends Controller
{
	public function alloption(){
		$asuransi_id = Input::get('asuransi_id');
        $asuransi = Asuransi::find($asuransi_id);
		$query = 'SELECT f.boleh_dipuyer as boleh_dipuyer, ';
		$query .= 'm.id as merek_id, ';
		$query .= 's.sediaan as sediaan, ';
		$query .= 'r.id as rak_id, ';
		$query .= 'f.id as formula_id, ';
		$query .= 'm.merek, ';
		$query .= 'r.harga_beli, ';
		$query .= 'f.aturan_minum_id as aturan_minum_id, ';
		$query .= 'f.peringatan as peringatan, ';
		$query .= 'r.fornas as fornas, ';
		$query .= 'g.generik as generik, ';
		$query .= 'k.bobot as bobot, ';
		$query .= 'r.harga_jual as harga_jual ';
		$query .= 'FROM mereks as m ';
		$query .= 'JOIN raks as r on r.id = m.rak_id ';
		$query .= 'JOIN formulas as f on f.id = r.formula_id ';
		$query .= 'JOIN sediaans as s on s.id = f.sediaan_id ';
		$query .= 'LEFT JOIN komposisis as k on f.id = k.formula_id ';
		$query .= 'LEFT JOIN generiks as g on g.id = k.generik_id ';
		$query .= "WHERE m.discontinue = 0 ";
		$query .= "AND m.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= $asuransi->tipe_asuransi_id == 5 ? 'ORDER BY r.kelas_obat_id DESC':'ORDER BY m.id ASC';
		$data =  DB::select($query);
		return $this->formatDdlNamaObat($data);
	}
	public function alloption2(){

        $asuransi_id = Input::get('asuransi_id');

		$query  = "SELECT f.boleh_dipuyer as boleh_dipuyer, ";
		$query .= "r.harga_jual as harga_jual, ";
		$query .= "m.id as merek_id, ";
		$query .= "s.sediaan as sediaan, ";
		$query .= "r.id as rak_id, ";
		$query .= "f.id as formula_id, ";
		$query .= "m.merek, ";
		$query .= "d.jumlah as jumlah, ";
		$query .= "d.jumlah_bpjs as jumlah_bpjs, ";
		$query .= "d.jumlah_puyer_add as jumlah_puyer_add, ";
		$query .= "d.signa_id as signa_id, ";
		$query .= "r.harga_beli, ";
		$query .= "g.generik as generik, ";
		$query .= "k.bobot as bobot, ";
		$query .= "f.aturan_minum_id, ";
		$query .= "f.peringatan as peringatan, ";
		$query .= "r.fornas as fornas ";
		$query .= "FROM mereks as m ";
		$query .= "JOIN raks as r on r.id = m.rak_id ";
		$query .= "join formulas as f on f.id = r.formula_id ";
		$query .= 'LEFT JOIN komposisis as k on f.id = k.formula_id ';
		$query .= 'LEFT JOIN generiks as g on g.id = k.generik_id ';
		$query .= 'LEFT JOIN sediaans as s on s.id = f.sediaan_id ';
		$query .= "JOIN doses as d on f.id = d.formula_id ";
		$query .= "WHERE d.berat_badan_id = '{$berat_badan_id}'";
		$query .= "AND m.discontinue = 0 ";
		$query .= "AND m.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= $asuransi->tipe_asuransi_id == 5 ? 'ORDER BY r.kelas_obat_id DESC':'ORDER BY m.id ASC';
		$data   = DB::select($query);
		$i      = 0;
		$bb     = Input::get('bb');

		$berat_badan_id = Yoga::beratBadanId($bb);
		$asuransi_id    = Input::get('asuransi_id');
		$asuransi       = Asuransi::find($asuransi_id);

		$mereks = [];
		$i      = 0;
		foreach ($data as $dt) {
			$mereks[$dt->merek_id]['merek_id']                  = $dt->merek_id;
			$mereks[$dt->merek_id]['sediaan']                   = $dt->sediaan;
			$mereks[$dt->merek_id]['rak_id']                    = $dt->rak_id;
			$mereks[$dt->merek_id]['formula_id']                = $dt->formula_id;
			$mereks[$dt->merek_id]['merek']                     = $dt->merek;
			$mereks[$dt->merek_id]['harga_beli']                = $dt->harga_beli;
			$mereks[$dt->merek_id]['aturan_minum_id']           = $dt->aturan_minum_id;
			$mereks[$dt->merek_id]['peringatan']                = $dt->peringatan;
			$mereks[$dt->merek_id]['fornas']                    = $dt->fornas;
			$mereks[$dt->merek_id]['harga_jual']                = $dt->harga_jual;
			$mereks[$dt->merek_id]['ID_TERAPI']                 = strval($i);
			$mereks[$dt->merek_id]['komposisi'][]               = $dt->generik . ' ' . $dt->bobot;
			$mereks[$dt->merek_id]['doses']['jumlah']           = $dt->jumlah;
			$mereks[$dt->merek_id]['doses']['jumlah_puyer_add'] = $dt->jumlah_puyer_add;
			$mereks[$dt->merek_id]['doses']['jumlah_bpjs']      = $dt->jumlah_bpjs;
			$mereks[$dt->merek_id]['doses']['signa_id']         = $dt->signa_id;
			$i++;	
		}
		$datas = [];
		foreach ($mereks as $mr) {
			$datas[] = $mr;
		}

		$temp = [
			'berat_badan' => BeratBadan::find($berat_badan_id)->berat_badan,
			'temp'        => $datas
		];
		return json_encode($temp);
	}

	public function optionpuyer(){
        $asuransi_id = Input::get('asuransi_id');

		$query = "SELECT f.boleh_dipuyer as boleh_dipuyer, ";
		$query .= "r.harga_jual as harga_jual, ";
		$query .= "f.aturan_minum_id as aturan_minum_id, ";
		$query .= "m.id as merek_id, ";
		$query .= "s.sediaan as sediaan, ";
		$query .= "r.id as rak_id, ";
		$query .= "f.id as formula_id, ";
		$query .= "m.merek, ";
		$query .= 'g.generik as generik, ';
		$query .= 'k.bobot as bobot, ';
		$query .= "r.harga_beli, ";
		$query .= "f.peringatan as peringatan, ";
		$query .= "r.fornas as fornas ";
		$query .= "FROM mereks as m ";
		$query .= "JOIN raks as r on r.id = m.rak_id ";
		$query .= "join formulas as f on f.id = r.formula_id ";
		$query .= 'LEFT JOIN komposisis as k on f.id = k.formula_id ';
		$query .= 'LEFT JOIN generiks as g on g.id = k.generik_id ';
		$query .= 'LEFT JOIN sediaans as s on s.id = f.sediaan_id ';
		$query .= "WHERE s.sediaan = 'capsul' ";
		$query .= "AND m.discontinue = 0 ";
		$query .= "AND m.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "or s.sediaan = 'tablet' ";
		$query .= $asuransi->tipe_asuransi_id == 5 ? 'ORDER BY r.kelas_obat_id DESC':'ORDER BY m.id ASC';
		$data =  DB::select($query);

		return $this->formatDdlNamaObat($data);
	}
	public function optionsyrup(){
        $asuransi_id = Input::get('asuransi_id');

		$query = "SELECT f.boleh_dipuyer as boleh_dipuyer, ";
		$query .= "r.harga_jual as harga_jual, ";
		$query .= "m.id as merek_id, ";
		$query .= "f.aturan_minum_id as aturan_minum_id, ";
		$query .= "s.sediaan as sediaan, ";
		$query .= "r.id as rak_id, ";
		$query .= "f.id as formula_id, ";
		$query .= "m.merek, ";
		$query .= 'g.generik as generik, ';
		$query .= 'k.bobot as bobot, ';
		$query .= "r.harga_beli, ";
		$query .= "f.peringatan as peringatan, ";
		$query .= "r.fornas as fornas ";
		$query .= "FROM mereks as m ";
		$query .= "JOIN raks as r on r.id = m.rak_id ";
		$query .= "join formulas as f on f.id = r.formula_id ";
		$query .= 'LEFT JOIN komposisis as k on f.id = k.formula_id ';
		$query .= 'LEFT JOIN generiks as g on g.id = k.generik_id ';
		$query .= 'LEFT JOIN sediaans as s on s.id = f.sediaan_id ';
		$query .= "WHERE s.sediaan like '%syrup%' ";
		$query .= "AND m.discontinue = 0 ";
		$query .= "AND m.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= $asuransi->tipe_asuransi_id == 5 ? 'ORDER BY r.kelas_obat_id DESC':'ORDER BY m.id ASC';
		$data =  DB::select($query);
		return $this->formatDdlNamaObat($data);
	}
	public function formatDdlNamaObat($data){
        $asuransi = !is_null( Input::get('asuransi_id') ) ? Asuransi::find( Input::get('asuransi_id') ) : null;
		$mereks = [];
		$i = 0;

        if (
            !is_null($asuransi) &&
            $asuransi->tipe_asuransi_id == 5
        ) {
            $khusus_bpjs = [];
            foreach ($data as $da) {
                $khusus_bpjs[$da->formula_id] = $da;
            }
        }
		foreach ($data as $dt) {
			$mereks[$dt->merek_id]['merek_id']        = $dt->merek_id;
			$mereks[$dt->merek_id]['sediaan']         = $dt->sediaan;
			$mereks[$dt->merek_id]['rak_id']          = $dt->rak_id;
			$mereks[$dt->merek_id]['formula_id']      = $dt->formula_id;
			$mereks[$dt->merek_id]['merek']           = $dt->merek;
			$mereks[$dt->merek_id]['aturan_minum_id'] = $dt->aturan_minum_id;
			$mereks[$dt->merek_id]['peringatan']      = $dt->peringatan;
            if ( $asuransi->tipe_asuransi_id == 5 ) {
                $mereks[$dt->merek_id]['fornas']          = $khusus_bpjs[$dt->formula_id]->fornas;
                $mereks[$dt->merek_id]['harga_beli']      = $khusus_bpjs[$dt->formula_id]->harga_beli;
                $mereks[$dt->merek_id]['harga_jual']      = $khusus_bpjs[$dt->formula_id]->harga_jual;
            } else {
                $mereks[$dt->merek_id]['fornas']          = $dt->fornas;
                $mereks[$dt->merek_id]['harga_beli']      = $dt->harga_beli;
                $mereks[$dt->merek_id]['harga_jual']      = $dt->harga_jual;
            }
			$mereks[$dt->merek_id]['ID_TERAPI']       = strval($i);
			$mereks[$dt->merek_id]['komposisi'][]     = $dt->generik . ' ' . $dt->bobot;
			$i++;	
		}
		$datas = [];
		foreach ($mereks as $mr) {
			$datas[] = $mr;
		}
		return json_encode($datas);
	}
	

}
