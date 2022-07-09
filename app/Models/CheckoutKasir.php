<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class CheckoutKasir extends Model
{
    use BelongsToTenant, HasFactory;
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
    
    public function getKetjurnalAttribute(){
        $tanggal = $this->created_at->format('d-m-Y');
        $uang = $this->nilai;

        return 'Checkout sebesar <span class="uang">' . $uang . '</span> dipindahkan  ke kas di tangan  pada tanggal ' . $tanggal;

    }
}

