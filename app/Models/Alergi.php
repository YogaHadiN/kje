<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Alergi extends Model
{
    use BelongsToTenant, HasFactory;
	protected $table = 'alergies';
	public function generik(){
		return $this->belongsTo('App\Models\Generik');
	}
}
