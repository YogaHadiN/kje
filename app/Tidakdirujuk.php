<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class Tidakdirujuk extends Model{
	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $guarded = ['id'];

	public function icd10(){

		return $this->belongsTo('App\Icd10');
	}

}
