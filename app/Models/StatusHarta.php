<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 
use App\Models\StatusHarta;

class StatusHarta extends Model
{
    use BelongsToTenant;
	public static function list(){
		return[ null => 'pilih' ] + StatusHarta::pluck('status_harta', 'id')->all();
	}
}
