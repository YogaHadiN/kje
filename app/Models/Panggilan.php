<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panggilan extends Model
{
	public function antrian(){
		return $this->belongsTo('App\Models\Antrian');
	}
}
