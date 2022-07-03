<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class AkunBank extends Model
{
    use BelongsToTenant;

    public function rekening(){
        return $this->hasMany(Rekening::class);
    }
    
}
