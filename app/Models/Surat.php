<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Surat extends Model
{
    use BelongsToTenant;
	protected $dates = [
		'tanggal'
	];
}
