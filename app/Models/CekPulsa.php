<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CekPulsa extends Model
{
	protected $dates = ['created_at', 'expired_gammu', 'expired_zenziva'];
	public function staf(){
		return $this->belongsTo('App\Models\Staf');
	}
}
