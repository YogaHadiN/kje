<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BukanPeserta extends Model
{
	public function periksa(){
		return $this->belongsTo('App\Models\Periksa');
	}
}
