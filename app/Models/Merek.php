<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Terapi;
use App\Models\Classes\Yoga;
use Session;

class Merek extends Model{
	public static function boot(){
		parent::boot();
		self::deleting(function($merek){
			if (Terapi::where('merek_id', $merek->id)->count()) {
				$pesan = 'Tidak bisa menghapus karena <strong>' . $merek->merek .'</strong> sudah pernah digunakan, rubah bila perlu!';
				Session::flash('pesan', Yoga::gagalFlash($pesan));
				return false;
			}
		});
		self::deleted(function($merek){
			$pesan = 'Merek ' .$merek->merek .' BERHASIL dihapus';
			$rak = Rak::find($merek->rak_id);
			if (Merek::where('rak_id', $merek->rak_id)->count() < 1) {
				$rak->delete();
				$pesan .= '<br />';
				$pesan .= 'Rak <strong>' . $merek->rak_id  . ' BERHASIL</strong> dihapus karena tidak ada merek lagi yang menaunginya';
			}

			if (Rak::where('formula_id', $rak->formula_id)->count() < 1) {
				Formula::destroy($rak->formula);
				$pesan .= '<br />';
				$pesan .= 'Formula <strong>' . $rak->formula_id  . ' BERHASIL</strong> dihapus karena tidak ada merek lagi yang menaunginya';
			}
			Session::flash('pesan', Yoga::suksesFlash($pesan));
			return true;
		});
	}
	public $incrementing = false; 
    protected $keyType = 'string';

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $guarded = [];

	public function rak() {
		return $this->belongsTo('App\Models\Rak');
	}
	public function pembelian() {
		return $this->hasMany('App\Models\Pembelian');
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
		$merek_id   = $this->id;
		$formula_id = $this->rak->formula_id;
		$rak_id     = $this->rak_id;
		$harga_jual = $this->rak->harga_jual;

		$data = [
			'merek_id'   => $merek_id,
			'rak_id'     => $rak_id,
			'fornas'     => Rak::find($rak_id)->fornas,
			'formula_id' => $formula_id,
			'harga_jual' => $harga_jual,
			'harga_beli' => $this->rak->harga_beli
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
	public static function list(){
		return array('' => '- Pilih Merek -') + Merek::pluck('merek', 'id')->all();
	}
}
