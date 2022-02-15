<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoliAntrian extends Model
{
	public function poli(){
		return $this->belongsTo('App\Models\Poli');
	}
}
