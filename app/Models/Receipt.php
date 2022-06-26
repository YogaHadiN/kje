<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Receipt extends Model
{
    use BelongsToTenant;
    //
}
