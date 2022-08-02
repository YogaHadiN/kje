<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Discount extends Model
{
    use BelongsToTenant, HasFactory;
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
