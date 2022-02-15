<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alergi extends Model
{
	protected $table = 'alergies';
	public function generik(){
		return $this->belongsTo('App\Models\Generik');
	}
}
