<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Sediaan extends Model
{
    use BelongsToTenant;
	public $incrementing = false; 
    protected $keyType = 'string';
}
