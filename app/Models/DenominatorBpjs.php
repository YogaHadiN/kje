<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BelongsToTenant; 
use Illuminate\Database\Eloquent\Model;

class DenominatorBpjs extends Model
{
    use BelongsToTenant, HasFactory;
    protected $dates = [
        'bulanTahun'
    ];
}
