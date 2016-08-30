<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model{

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $guarded = [];
	protected $dates = ['created_at'];


	public function Fakturbeli(){

		return $this->hasMany('Fakturbeli');
	}

}
