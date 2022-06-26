<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class ServiceAc extends Model
{
    use BelongsToTenant;
	public function ac(){
		return $this->belongsTo('App\Models\Ac');
	}
}
