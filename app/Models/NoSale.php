<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 
use Input;

class NoSale extends Model
{
    use BelongsToTenant;
    //
    public function staf(){
         return $this->belongsTo('App\Models\Staf');
    }
    
    protected $dates = ['created_at'];
}
