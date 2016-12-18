<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PesanMasuk extends Model
{
	public function periksa(){
		return $this->belongsTo('App\Periksa');
	}
}
