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
		$query = "SELECT * FROM jurnal_umums";
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
				foreach ($ar as $a) {
					$errors[] = $a->id;
				}
			}
		}
		return dd( JurnalUmum::destroy($errors) );
		
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
