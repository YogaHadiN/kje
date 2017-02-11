<?php



namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use DB;
use App\Asuransi;
use App\JurnalUmum;


class TestController extends Controller
{

	public function index(){
		$query = "SELECT * FROM jurnal_umums where jurnalable_type='App\\\Periksa'";
		$jurnals = DB::select($query);
		//$jurnals = JurnalUmum::all();
		$arr = [];
		foreach ($jurnals as $ju) {
			$arr[$ju->jurnalable_type . $ju->jurnalable_id][] = $ju;
		}
		$errors = [];
		foreach ($arr as $ar) {
			$debit = 0;
			$kredit = 0;
			foreach ($ar as $array) {
				if ($array->debit == 1) {
					$debit += $array->nilai;
				}
				if ($array->debit == 0) {
					$kredit += $array->nilai;
				}
			}
			if ($debit != $kredit) {
				$errors[] = [
					'periksa_id' => $ar[0]->jurnalable_id,
					'created_at' => $ar[0]->created_at
				];
			}
		}
		$datas = [];
		foreach ($errors as $er) {
			$periksa = Periksa::find($er['periksa_id']);
			if ($periksa->asuransi->nama = 'PT SEJIN') {
				$datas[] = [
					'jurnalable_type' => 'App\Periksa',
					'jurnalable_id' => $er['periksa_id'],
					'nilai' => $periksa->piutang,
					'created_at' => $er['created_at'],
					'updated_at' => $er['created_at'],
					'debit' => 1,
					'coa_id' =>111010
				];
			}
		}
		return JurnalUmum::insert($datas);
	}

	public function ajax(){
		$q     = Input::get('q');
		$words = str_split($q);
		$param = '%';
		foreach ($words as $w) {
			$param .= $w .'%';
		}
		$asuransis = Asuransi::where('nama', 'like', $param)->get();
		$result = [];
		foreach ($asuransis as $asu) {
			$result[] = [
				 'id' => $asu->id,
				 'nama' => $asu->nama
			];
		}
		return json_encode($result);
		
	}
	

}
