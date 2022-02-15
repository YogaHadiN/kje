<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Monitor extends Model{
	protected $fillable = [];

	public function periksa(){
		return $this->belongsTo('App\Models\Periksa');
	}
}
