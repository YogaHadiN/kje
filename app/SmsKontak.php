<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsKontak extends Model
{
	protected $guarded = ['id'];
	protected $dates = ['created_at'];
	public function pasien(){
		return $this->belongsTo('App\Pasien');
	}
}
