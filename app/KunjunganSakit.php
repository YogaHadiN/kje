<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KunjunganSakit extends Model
{
	protected $guarded = ['id'];
	protected $dates = ['created_at'];

	public function periksa(){
		return $this->belongsTo('App\Periksa');
	}
}
