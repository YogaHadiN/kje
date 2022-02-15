<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
	public function periksa(){
		return $this->belongsTo('App\Models\Periksa');
	}

	public function promoable(){
		return $this->morphTo();
	}
}

