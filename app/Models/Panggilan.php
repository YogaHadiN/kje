<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Panggilan extends Model
{
    use BelongsToTenant;
	public function antrian(){
		return $this->belongsTo('App\Models\Antrian');
	}
}
