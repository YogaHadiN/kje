<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coa extends Model{
	protected $fillable = [];
	public $incrementing = false; 

	public function kelompokCoa(){

		return $this->belongsTo('App\KelompokCoa');
	}
	
}
