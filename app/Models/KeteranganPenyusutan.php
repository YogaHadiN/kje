<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class KeteranganPenyusutan extends Model
{
    use BelongsToTenant;
	public function golonganPeralatan(){
		return $this->belongsTo('App\Models\GolonganPeralatan');
	}
}
