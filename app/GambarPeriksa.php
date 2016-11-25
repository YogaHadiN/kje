<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GambarPeriksa extends Model
{
	public function gambarable(){
		return $this->morphTo();
	}
}
