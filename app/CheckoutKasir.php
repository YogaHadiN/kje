<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckoutKasir extends Model
{
    protected $dates = ['created_at'];

    public function getTanggalAttribute(){
        return $this->created_at->format('d-m-Y');
    }
    
}
