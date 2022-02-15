<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsGagal extends Model
{
	protected $guarded = ['id'];
	public function pasien(){
		return $this->belongsTo('App\Models\Pasien');
	}
}
