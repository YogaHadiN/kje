<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Promo extends Model
{
    use BelongsToTenant, HasFactory;
    protected $guarded = [];
	public function promoable(){
		return $this->morphTo();
	}
}

