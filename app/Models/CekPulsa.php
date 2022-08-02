<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class CekPulsa extends Model
{
    use BelongsToTenant, HasFactory;
	protected $dates = ['created_at', 'expired_gammu', 'expired_zenziva'];
	public function staf(){
		return $this->belongsTo('App\Models\Staf');
	}
}
