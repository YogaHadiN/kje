<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AntrianPeriksa extends Model{
	public $incrementing = false; 

	// Add your validation rules here
	public static $rules = [
		'asuransi_id' => 'required',
		'pasien_id' => 'required',
		'staf_id' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function asuransi() {
		return $this->belongsTo('App\Asuransi');
	}
	public function pasien() {
		return $this->belongsTo('App\Pasien');
	}
	public function staf() {
		return $this->belongsTo('App\Staf');
	}
	public function perujuk(){
		return $this->belongsTo('App\Perujuk');
	}

}