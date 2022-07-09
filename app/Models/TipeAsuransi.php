<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class TipeAsuransi extends Model
{
    use BelongsToTenant, HasFactory;
    //
}
