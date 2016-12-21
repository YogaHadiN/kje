<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ac;

class Ac extends Model
{
	public static function list(){
		return [ null => '-Pilih-' ] + Ac::lists('id', 'keterangan')->all();
	}
	
}
