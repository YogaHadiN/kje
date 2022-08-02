<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Komposisi extends Model{
    use BelongsToTenant, HasFactory;

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $guarded = [];

	public function formula(){
		return $this->belongsTo('App\Models\Formula');
	}

	public function generik(){
		return $this->belongsTo('App\Models\Generik');
	}

}
