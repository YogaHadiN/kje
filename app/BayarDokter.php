<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BayarDokter extends Model
{
    //
    protected $dates = ['created_at'];
    public function staf(){
         return $this->belongsTo('App\Staf');
    }
    
}
