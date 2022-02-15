<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceAc extends Model
{
	public function ac(){
		return $this->belongsTo('App\Models\Ac');
	}
}
