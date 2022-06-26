<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Ht extends Model
{
    use BelongsToTenant;
    //
}
