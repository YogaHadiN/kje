<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Fasilitas extends Model
{
    use BelongsToTenant, HasFactory;
    //
}
