<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class PoliAntrian extends Model
{
    use HasFactory;
	public function poli(){
		return $this->belongsTo('App\Models\Poli');
	}
}
