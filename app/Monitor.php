<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Monitor extends Model{
	protected $fillable = [];

	public function periksa(){
		return $this->belongsTo('App\Periksa');
	}
}