<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisTarif extends Model{

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function tarif(){

		return $this->hasMany('Tarif');
		
	}
	public function bahanHabisPakai(){

		return $this->hasMany('App\BahanHabisPakai');
		
	}
	public function bhp(){

		return $this->hasMany('App\BahanHabisPakai');
		
	}

}
