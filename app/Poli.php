<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Poli;

class Poli extends Model
{
	public static function list(){
		return [ null => 'pilih' ] + Poli::lists('poli', 'id')->all();
	}
	
}
