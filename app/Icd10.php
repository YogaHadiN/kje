<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Icd10 extends Model{
	public $incrementing = false; 

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $guarded = [];


	public function diagnosa(){
		return $this->hasMany('App\Diagnosa');
	}

}
