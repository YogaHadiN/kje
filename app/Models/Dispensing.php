<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Dispensing extends Model{
    use BelongsToTenant;

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $guarded = [];


	public function merek(){
		return $this->belongsTo('App\Models\Merek');
	}
	public function rak(){
		return $this->belongsTo('App\Models\Rak');
	}
	public function terapi(){
		return $this->belongsTo('App\Models\Terapi');
	}

	public function pembelian(){
		return $this->belongsTo('App\Models\Pembelian');
	}

	public function dispensable(){
		return $this->morphTo();
	}

}
