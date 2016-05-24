<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perbaikantrx extends Model{

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];
	protected $table = 'perbaikantrxs';


	public function periksa(){

		return $this->belongsTo('App\Periksa');
	}
}