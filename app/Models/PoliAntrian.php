<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class PoliAntrian extends Model
{
    use BelongsToTenant;
	public function poli(){
		return $this->belongsTo('App\Models\Poli');
	}
}
