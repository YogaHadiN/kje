<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Manual extends Model
{
    use BelongsToTenant;
    //
}
