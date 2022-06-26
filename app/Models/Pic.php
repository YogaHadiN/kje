<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Pic extends Model
{
    use BelongsToTenant;
    //
}
