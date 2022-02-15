<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dose extends Model{

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function formula(){
		return $this->belongsTo('App\Models\Formula');
	}

	public function signa(){
		return $this->belongsTo('App\Models\Signa');
	}
	public function beratBadan(){
		return $this->belongsTo('App\Models\BeratBadan');
	}

}
