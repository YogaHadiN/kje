<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class AntrianApotek extends Model
{
    use BelongsToTenant, HasFactory;
    public function periksa(){
        return $this->belongsTo('App\Models\Periksa');
    }
	public function antrian(){
        return $this->morphOne('App\Models\Antrian', 'antriable');
	}
    public function antars(){
        return $this->morphMany('App\Models\PengantarPasien', 'antarable');
    }
}
