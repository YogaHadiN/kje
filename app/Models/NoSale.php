<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Input;

class NoSale extends Model
{
    //
    public function staf(){
         return $this->belongsTo('App\Models\Staf');
    }
    
    protected $dates = ['created_at'];
}
