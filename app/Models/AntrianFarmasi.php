<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AntrianFarmasi extends Model
{
    public function periksa(){
        return $this->belongsTo('App\Models\Periksa');
    }
	public function antrian(){
        return $this->morphOne('App\Models\Antrian', 'antriable');
	}
}
