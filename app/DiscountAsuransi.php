<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountAsuransi extends Model
{
	public function discount(){
		return $this->belongsTo('App\Discount');
	}

	public function jenisTarif(){
		return $this->belongsTo('App\JenisTarif');
	}
	public function asuransi(){
		return $this->belongsTo('App\Asuransi');
	}
}
