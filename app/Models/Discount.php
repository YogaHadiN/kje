<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
	protected $dates = [
		'dimulai',
		'berakhir'
	];
	public function discountAsuransi(){
		return $this->hasMany('App\Models\DiscountAsuransi');
	}
	public function jenisTarif(){
		return $this->belongsTo('App\Models\JenisTarif');
	}

}
