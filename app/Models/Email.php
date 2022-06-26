<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Email extends Model
{
    use BelongsToTenant;
	public function emailable(){
		return $this->morphto();
	}
}
