<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class SmsKirim extends Model
{
    use BelongsToTenant;
    //
}
