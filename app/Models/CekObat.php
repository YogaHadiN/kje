<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class CekObat extends Model
{
    use BelongsToTenant, HasFactory;
	protected $dates = ['created_at'];
	public function rak(){
		return $this->belongsTo('App\Models\Rak');
	}
	public function staf(){
		return $this->belongsTo('App\Models\Staf');
	}
}
