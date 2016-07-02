<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TujuanRujuk extends Model
{
	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function rujukan(){

		return $this->hasMany('Rujukan');
		
	}

    public function rumahSakit(){
         return $this->belongsToMany('RumahSakit', 'fasilitas');
    }

}
