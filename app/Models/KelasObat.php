<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class KelasObat extends Model
{
    use HasFactory;
	public static function list(){
		return  KelasObat::pluck('kelas_obat', 'id');
	}
}
