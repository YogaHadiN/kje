<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Merek extends Model{
	public $incrementing = false; 

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $guarded = [];

	public function rak() {
		return $this->belongsTo('App\Rak');
	}
	public function pembelian() {
		return $this->hasMany('App\Pembelian');
	}

	public function getKomposisiBymerekAttribute(){

		$data = '<br />';

		foreach($this->rak->formula->komposisi as $komposisi){
			$data .= $komposisi->generik->generik . ' ' . $komposisi ->bobot . ', <br />';
		}

		return $data;
	}
	public function getKomposisiInlineAttribute(){

		$data = '';

		foreach($this->rak->formula->komposisi as $komposisi){
			$data .= $komposisi->generik->generik . ' ' . $komposisi ->bobot . ', ';
		}

		return $data;
	}

	public function getValueDdlAttribute(){

		$rak_id = $this->rak->id;
		$formula_id = $this->rak->formula->id;
		$merek_id = $this->id;
		$harga_beli = $this->rak->harga_beli;

		$data = [
			'formula_id' => $formula_id,
			'merek_id' => $merek_id,
			'rak_id' => $rak_id,
			'harga_beli' => $harga_beli
		];

		return json_encode($data);

	}
	public function getMerekFormulaAttribute(){

		$formula_id = $this->rak->formula->id;


		$raks = Rak::where('formula_id', $formula_id)->get();
		$ddlMerek = [];

		foreach ($raks as $rak) {
			foreach ($rak->merek as $merek) {

				$ddlMerek[$merek->id] = $merek->merek;

			}
		}

		return $ddlMerek;

	}
	public function getMerekJualAttribute(){
		$merek_id = $this->id;
		$formula_id = $this->rak->formula_id;
		$rak_id = $this->rak_id;
		$harga_jual = $this->rak->harga_jual;

		$data = [
			'merek_id' => $merek_id,
			'rak_id' => $rak_id,
			'fornas' => Rak::find($rak_id)->fornas,
			'formula_id' => $formula_id,
			'harga_jual' => $harga_jual
		];

		return json_encode($data);

	}

	public function getCustidAttribute(){

		$merek_id = $this->id;
		$harga_jual = $this->rak->harga_jual;
		$harga_beli = $this->rak->harga_beli;
		$formula_id = $this->rak->formula_id;
		$exp_date = $this->rak->exp_date;
		$class_rak = $this->rak->kelas_obat_id;
		$sediaan = $this->rak->formula->sediaan;

		$data = [
			'merek_id' => $merek_id,
			'harga_jual' => $harga_jual,
			'exp_date' => $exp_date,
			'sediaan' => $sediaan,
			'class_rak' => $class_rak,
			'formula_id' => $formula_id,
			'harga_beli' => $harga_beli
		];

		return json_encode($data);

	}

	public function getPalingmurahAttribute(){
		$pembelian = Pembelian::where('merek_id', $this->id)->orderBy('harga_beli', 'asc')->first();
		if (count($pembelian) > 0) {
			return $pembelian->fakturBelanja->supplier->nama . ' -Rp. ' . $pembelian->harga_beli;
		}

	}

}
