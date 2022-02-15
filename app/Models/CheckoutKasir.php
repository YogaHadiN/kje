<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckoutKasir extends Model
{
    protected $dates = ['created_at'];

    public function getTanggalAttribute(){
        return $this->created_at->format('d-m-Y');
    }
    
    protected $morphClass = 'App\Models\CheckoutKasir';
    public function jurnals(){
        return $this->morphMany('App\Models\JurnalUmum', 'jurnalable');
    }
    public function checkoutDetail(){
         return $this->hasMany('App\Models\CheckoutDetail');
    }
    
    public function jenisTarif(){
         return $this->belongsTo('App\Models\JenisTarif');
    }

    
    public function getKetjurnalAttribute(){
        $tanggal = $this->created_at->format('d-m-Y');
        $uang = $this->nilai;

        return 'Checkout sebesar <span class="uang">' . $uang . '</span> dipindahkan  ke kas di tangan  pada tanggal ' . $tanggal;

    }
}

