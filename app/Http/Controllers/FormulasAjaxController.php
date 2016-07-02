<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Merek;
use App\Formula;
use DB;
use App\Rak;


class FormulasAjaxController extends Controller
{

	

	public function ajaxformula(){

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
}