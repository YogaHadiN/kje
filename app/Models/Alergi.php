<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Alergi extends Model
{
    use BelongsToTenant;
	protected $table = 'alergies';
	public function generik(){
		return $this->belongsTo('App\Models\Generik');
	}
}
