<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Komposisi extends Model{

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function formula(){
		return $this->belongsTo('App\Formula');
	}

	public function generik(){
		return $this->belongsTo('App\Generik');
	}

}