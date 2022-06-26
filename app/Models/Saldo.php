<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Saldo extends Model
{
    use BelongsToTenant;
	public function staf(){
		return $this->belongsTo('App\Models\Staf');
	}
}
