<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CekListrik extends Model
{
	public function staf(){
		return $this->belongsTo('App\Models\Staf');
	}
}
