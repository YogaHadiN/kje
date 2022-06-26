<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 
use App\Models\RolePengiriman;

class RolePengiriman extends Model
{
    use BelongsToTenant;
	protected $table = 'role_pengirimans';
	public static function list(){
		return array(null => '- Pilih Role Pengiriman -') + RolePengiriman::pluck('role_pengiriman', 'id')->all();
	}
	
}
