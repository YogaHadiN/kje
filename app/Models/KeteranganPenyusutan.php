<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeteranganPenyusutan extends Model
{
	public function golonganPeralatan(){
		return $this->belongsTo('App\Models\GolonganPeralatan');
	}
}
