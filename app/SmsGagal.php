<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsGagal extends Model
{
	protected $guarded = ['id'];
	public function pasien(){
		return $this->belongsTo('App\Pasien');
	}
}
