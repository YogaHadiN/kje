<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Penjualan extends Model{
    use BelongsToTenant, HasFactory;
	
	protected $fillable = [];
	protected $guarded = [];

    public function merek(){
         return $this->belongsTo('App\Models\Merek');
    }
    
    public function notaJual(){
         return $this->belongsTo('App\Models\NotaJual');
    }
	
}
