<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Input;

class NoSale extends Model
{
    //
    public function staf(){
         return $this->belongsTo('App\Staf');
    }
    
    protected $dates = ['created_at'];
}
