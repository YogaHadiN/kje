<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PembayaranAsuransi extends Model
{
    //
    public function asuransi(){
         return $this->belongsTo('App\Asuransi');
    }
}
