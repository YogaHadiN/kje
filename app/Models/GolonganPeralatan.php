<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class GolonganPeralatan extends Model
{
    use BelongsToTenant, HasFactory;
	public function KeteranganPenyusutan(){
		return $this->hasMany('App\Models\KeteranganPenyusutan');
	}
}
