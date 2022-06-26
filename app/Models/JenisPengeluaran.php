<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class JenisPengeluaran extends Model{
    use BelongsToTenant;
	protected $fillable = [];
}
