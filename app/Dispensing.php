<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dispensing extends Model{
	public $incrementing = false; 

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $guarded = [];


	public function rak(){
		return $this->belongsTo('App\Rak');
	}

}