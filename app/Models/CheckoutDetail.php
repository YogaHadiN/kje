<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class CheckoutDetail extends Model
{
    use BelongsToTenant, HasFactory;
    public function coa(){
         return $this->belongsTo('App\Models\Coa');
    }
    
    //
}
