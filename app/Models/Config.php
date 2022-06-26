<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Config extends Model
{
    use BelongsToTenant;
    //
}
