<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GolonganPeralatan extends Model
{
	public function KeteranganPenyusutan(){
		return $this->hasMany('App\Models\KeteranganPenyusutan');
	}
}
