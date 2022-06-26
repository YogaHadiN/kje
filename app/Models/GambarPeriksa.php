<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class GambarPeriksa extends Model
{
    use BelongsToTenant;
	public function gambarable(){
		return $this->morphTo();
	}
}
