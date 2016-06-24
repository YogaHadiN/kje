<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckoutKasir extends Model
{
    protected $dates = ['created_at'];

    public function getTanggalAttribute(){
        return $this->created_at->format('d-m-Y');
    }
    
    protected $morphClass = 'App\CheckoutKasir';
    public function jurnals(){
        return $this->morphMany('App\JurnalUmum', 'jurnalable');
    }
    public function checkoutDetail(){
         return $this->hasMany('App\CheckoutDetail');
    }
    
    public function jenisTarif(){
         return $this->belongsTo('App\JenisTarif');
    }

    
    public function getKetjurnalAttribute(){
        $tanggal = $this->created_at->format('d-m-Y');
        $uang = $this->nilai;

        return 'Checkout sebesar <span class="uang">' . $uang . '</span> dipindahkan  ke kas di tangan  pada tanggal ' . $tanggal;

    }
}

