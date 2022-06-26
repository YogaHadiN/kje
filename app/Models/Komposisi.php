<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Komposisi extends Model{
    use BelongsToTenant;

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function formula(){
		return $this->belongsTo('App\Models\Formula');
	}

	public function generik(){
		return $this->belongsTo('App\Models\Generik');
	}

}
