<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class KelasObat extends Model
{
    use BelongsToTenant;
	public static function list(){
		return  KelasObat::pluck('kelas_obat', 'id');
	}
}
