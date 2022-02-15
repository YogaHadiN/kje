<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PiutangAsuransi extends Model
{
    public function periksa(){
        return $this->belongsTo('App\Models\Periksa');
    }
}
