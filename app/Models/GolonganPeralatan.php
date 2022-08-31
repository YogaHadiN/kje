<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class GolonganPeralatan extends Model
{
    use HasFactory;
	public function KeteranganPenyusutan(){
		return $this->hasMany('App\Models\KeteranganPenyusutan');
	}
}
