<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modal extends Model
{
    
    public function coa(){
         return $this->belongsTo('Coa', 'coa_kas_id');
    }
    
}
