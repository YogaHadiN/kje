<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Icd10 extends Model{

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $guarded = [];


	public function diagnosa(){
		return $this->hasMany('App\Models\Diagnosa');
	}

}
