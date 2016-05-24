<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotaBeli extends Model{
	public $incrementing = false; 
	
	protected $fillable = [];
	protected $guarded = [];


	public function staf(){

		return $this->belongsTo('App\Staf');
	}
	public function supplier(){

		return $this->belongsTo('App\Supplier');
	}
}