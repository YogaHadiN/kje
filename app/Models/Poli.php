<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 
use App\Models\Poli;

class Poli extends Model
{
    use BelongsToTenant, HasFactory;
	public static function list(){
		return [ null => 'pilih' ] + Poli::pluck('poli', 'id')->all();
	}
	public function poli_antrian(){
		return $this->hasOne('App\Models\PoliAntrian');
	}
	
}
