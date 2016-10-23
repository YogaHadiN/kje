<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsBpjs extends Model
{
	public $incrementing = false; 

	public function pasien(){
		return $this->belongsTo('App\Pasien');
	}
}
