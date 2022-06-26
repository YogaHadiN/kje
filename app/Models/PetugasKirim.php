<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class PetugasKirim extends Model
{
    use BelongsToTenant;
	public function staf(){
		return $this->belongsTo('App\Models\Staf');
	}
	public function role_pengiriman(){
		return $this->belongsTo('App\Models\RolePengiriman');
	}
}
