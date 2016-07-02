<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model{
	public $incrementing = false; 

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $guarded = [];

	public function asuransi(){

		return $this->belongsTo('App\Asuransi');
	}

	public function periksa(){

		return $this->hasMany('App\Periksa');
	}


	public function registerHamil(){

		return $this->hasMany('App\RegisterHamil');
	}
}