<?php

namespace App\Http\Controllers;

use Input;

use App\Http\Requests;

use App\Formula;
use App\Rak;

class PembeliansAjaxController extends Controller
{

	

	public function formulabyid(){

		$formula_id = Input::get('formula_id');

		$formula = Formula::find($formula_id);

		$dijual_bebas = ($formula->dijual_bebas == '1')? 'Ya' : 'TIdak'; 

		$komposisis = '';

		foreach ($formula->komposisi as $komposisi) {
			$komposisis .= $komposisi->generik->generik . ' ' . $komposisi->bobot . ', <br />'; 
		}

		$mereks = '';

		foreach ($formula->rak as $raks) {
			foreach ($raks->merek as $merek) {
				$mereks .= $merek->merek . ', <br />';
			}
		}

		$data = [

		'dijual_bebas' => $dijual_bebas,
		'efek_samping' => $formula->efek_samping,
		'sediaan' => $formula->sediaan,
		'indikasi' => $formula->indikasi,
		'kontraindikasi' => $formula->kontraindikasi,
		'Komposisi' => $komposisis,
		'endfix' => $formula->endfix,
		'Merek' => $mereks

		];

		return json_encode($data);	

	}

	public function rakbyid(){

		$rak_id = Input::get('rak_id');

		$rak = Rak::find($rak_id);

		$data = [
			'merek'      => $rak->mereks,
			'komposisi'  => $rak->komposisis,
			'harga_beli' => $rak->harga_beli,
			'harga_jual' => $rak->harga_jual,
			'formula_id' => $rak->formula_id,
			'rak_id'     => $rak->id,
			'endfix'     => $rak->formula->endfix
		];

		return json_encode($data);

	}

}