<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model{
	public $incrementing = false; 
	
	protected $fillable = [];
	protected $guarded = [];

    public function merek(){
         return $this->belongsTo('App\Merek');
    }
    
	
}
