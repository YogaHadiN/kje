<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisAntrian extends Model
{
	public function poli_antrian(){
		return $this->hasMany('App\Models\PoliAntrian');
	}
	public function antrian_terakhir(){
		return $this->belongsTo('App\Models\Antrian', 'antrian_terakhir_id');
	}
}
