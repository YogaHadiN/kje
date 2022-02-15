<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telpon extends Model
{
	public function telponable(){
		return $this->morphto();
	}
}
