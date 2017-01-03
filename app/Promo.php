<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
	public function periksa(){
		return $this->belongsTo('App\Periksa');
	}

	public function promoable(){
		return $this->morphTo();
	}
}

