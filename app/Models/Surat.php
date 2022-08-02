<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Surat extends Model
{
    use BelongsToTenant, HasFactory;
	protected $dates = [
		'tanggal'
	];
}
