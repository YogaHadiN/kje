<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Monitor extends Model{
    use BelongsToTenant;
	protected $fillable = [];

	public function periksa(){
		return $this->belongsTo('App\Models\Periksa');
	}
}
