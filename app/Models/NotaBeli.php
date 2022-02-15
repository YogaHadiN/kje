<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaBeli extends Model{
	public $incrementing = false; 
    protected $keyType = 'string';
	
	protected $fillable = [];
	protected $guarded = [];


	public function staf(){

		return $this->belongsTo('App\Models\Staf');
	}
	public function supplier(){

		return $this->belongsTo('App\Models\Supplier');
	}
}
