<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
	protected $dates = [
		'dimulai',
		'berakhir'
	];
	public function discountAsuransi(){
		return $this->hasMany('App\DiscountAsuransi');
	}
	public function jenisTarif(){
		return $this->belongsTo('App\JenisTarif');
	}

}
