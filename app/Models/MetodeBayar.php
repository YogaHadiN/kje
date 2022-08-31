<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Models\MetodeBayar;

class MetodeBayar extends Model
{
    use HasFactory;
	public static function list(){
		return array('' => '- Pilih Metode Bayar -') + MetodeBayar::pluck('metode_bayar', 'id')->all();
	}
}
