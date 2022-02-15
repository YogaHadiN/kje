<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model{
	
	protected $fillable = [];
	protected $guarded = [];

    public function merek(){
         return $this->belongsTo('App\Models\Merek');
    }
    
    public function notaJual(){
         return $this->belongsTo('App\Models\NotaJual');
    }
	
}
