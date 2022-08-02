<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class AkunBank extends Model
{
    use BelongsToTenant, HasFactory;
    protected $guarded = [] ;

    public function rekening(){
        return $this->hasMany(Rekening::class);
    }
    
}
