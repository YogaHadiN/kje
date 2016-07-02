<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model{
	public $incrementing = false; 

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function merek(){

		return $this->belongsTo('App\Merek');
	}
	public function fakturBelanja(){

		return $this->belongsTo('App\FakturBelanja');
	}

}