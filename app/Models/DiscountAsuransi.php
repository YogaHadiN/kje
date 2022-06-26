<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class DiscountAsuransi extends Model
{
    use BelongsToTenant;
	public function discount(){
		return $this->belongsTo('App\Models\Discount');
	}

	public function jenisTarif(){
		return $this->belongsTo('App\Models\JenisTarif');
	}
	public function asuransi(){
		return $this->belongsTo('App\Models\Asuransi');
	}
}
