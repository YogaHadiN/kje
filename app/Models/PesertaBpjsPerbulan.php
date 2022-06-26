<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class PesertaBpjsPerbulan extends Model
{
    use BelongsToTenant;
    protected $dates = [
        'bulanTahun'
    ];
}
