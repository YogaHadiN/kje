<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsBpjs extends Model
{
	public function pasien(){
		return $this->belongsTo('App\Pasien');
	}
}
