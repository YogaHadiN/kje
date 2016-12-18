<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PesanKeluar extends Model
{
	public function periksa(){
		return $this->belongsTo('App\Periksa');
	}	
}
