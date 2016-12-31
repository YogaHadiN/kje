<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ac;

class Ac extends Model
{
	public static function list(){
		return [null => '-Pilih-'] + Ac::lists('keterangan', 'id')->all();
	}
	public function serviceAc(){
		return $this->hasMany('App\ServiceAc');
	}
	
}
