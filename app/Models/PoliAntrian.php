<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class PoliAntrian extends Model
{
    use BelongsToTenant, HasFactory;
	public function poli(){
		return $this->belongsTo('App\Models\Poli');
	}
}
