<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
	public function emailable(){
		return $this->morphto();
	}
}
