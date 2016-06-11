<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PiutangAsuransi extends Model
{
    //
    public function periksa(){
         return $this->belongsTo('App\Periksa');
    }
    
}
