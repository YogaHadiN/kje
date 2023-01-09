<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class TindakanGigi extends Model
{
    use BelongsToTenant,HasFactory;
    protected $guarded = [];
}
