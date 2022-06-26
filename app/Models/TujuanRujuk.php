<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class TujuanRujuk extends Model
{
    use BelongsToTenant;
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
