<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class HomeVisit extends Model
{
    use BelongsToTenant;
	public function pasien(){
		return $this->belongsTo('App\Models\Pasien');
	}
}
