<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class SmsGagal extends Model
{
    use BelongsToTenant;
	protected $guarded = ['id'];
	public function pasien(){
		return $this->belongsTo('App\Models\Pasien');
	}
}
