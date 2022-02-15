<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PiutangDibayar extends Model
{
    //
    public function periksa(){
        return $this->belongsTo('App\Models\Periksa');
    }
    public function pembayaranAsuransi(){
        return $this->belongsTo('App\Models\PembayaranAsuransi');
    }
    
}
