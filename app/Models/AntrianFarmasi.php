<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class AntrianFarmasi extends Model
{
    use BelongsToTenant;
    public function periksa(){
        return $this->belongsTo('App\Models\Periksa');
    }
	public function antrian(){
        return $this->morphOne('App\Models\Antrian', 'antriable');
	}
}
