<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class AkunBank extends Model
{
    use BelongsToTenant;
    protected $primaryKey = 'id';
    public $incrementing  = false;  // You most probably want this too
    protected $keyType    = 'string';

    public function rekening(){
        return $this->hasMany(Rekening::class);
    }
    
}
