<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
	public function staf(){
		return $this->belongsTo('App\Staf');
	}
}
