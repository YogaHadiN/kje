<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckoutDetail extends Model
{
    public function coa(){
         return $this->belongsTo('App\Models\Coa');
    }
    
    //
}
