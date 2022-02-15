<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ac;

class Ac extends Model
{
	public static function list(){
		return [null => '-Pilih-'] + Ac::pluck('keterangan', 'id')->all();
	}
	public function serviceAc(){
		return $this->hasMany('App\Models\ServiceAc');
	}
	
}
