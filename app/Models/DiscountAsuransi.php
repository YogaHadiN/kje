<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class DiscountAsuransi extends Model
{
    use BelongsToTenant, HasFactory;
	public function discount(){
		return $this->belongsTo('App\Models\Discount');
	}
	public function asuransi(){
		return $this->belongsTo('App\Models\Asuransi');
	}
}
