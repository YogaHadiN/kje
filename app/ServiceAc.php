<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceAc extends Model
{
	public function ac(){
		return $this->belongsTo('App\Ac');
	}
}
