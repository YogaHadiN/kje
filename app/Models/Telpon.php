<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Telpon extends Model
{
    use BelongsToTenant;
	public function telponable(){
		return $this->morphto();
	}
}
