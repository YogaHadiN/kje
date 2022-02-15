<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PetugasKirim extends Model
{
	public function staf(){
		return $this->belongsTo('App\Models\Staf');
	}
	public function role_pengiriman(){
		return $this->belongsTo('App\Models\RolePengiriman');
	}
}
