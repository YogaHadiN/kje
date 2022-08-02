<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Promo extends Model
{
    use BelongsToTenant, HasFactory;
	public function promoable(){
		return $this->morphTo();
	}
}

