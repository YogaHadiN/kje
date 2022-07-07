<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelasObat extends Model
{
	public static function list(){
		return  KelasObat::pluck('kelas_obat', 'id');
	}
}
