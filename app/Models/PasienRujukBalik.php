<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class PasienRujukBalik extends Model
{
    use BelongsToTenant, HasFactory;
	public function pasien(){
		return $this->belongsTo('App\Models\Pasien');
	}
}
