<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PiutangDibayar extends Model
{
    //
    public function periksa(){
        return $this->belongsTo('App\Periksa');
    }
    public function pembayaranAsuransi(){
        return $this->belongsTo('App\PembayaranAsuransi');
    }
    
}
