<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class KeteranganPenyusutan extends Model
{
    use BelongsToTenant, HasFactory;
	public function golonganPeralatan(){
		return $this->belongsTo('App\Models\GolonganPeralatan');
	}
}
