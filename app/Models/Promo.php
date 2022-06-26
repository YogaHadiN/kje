<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Promo extends Model
{
    use BelongsToTenant;
	public function periksa(){
		return $this->belongsTo('App\Models\Periksa');
	}

	public function promoable(){
		return $this->morphTo();
	}
}

