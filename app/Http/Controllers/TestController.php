<?php



namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use DB;
use App\Asuransi;


class TestController extends Controller
{

	public function index(){
		$name = 'yoga';
		$query = "SELECT * FROM users WHERE username like :id and id = :no";
		return DB::select($query, ['id' => 'yoga%', 'no' => 28]);
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
