<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Dm extends Model
{
    use BelongsToTenant;
    //
}
