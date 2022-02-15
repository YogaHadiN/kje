<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeVisit extends Model
{
	public function pasien(){
		return $this->belongsTo('App\Models\Pasien');
	}
}
