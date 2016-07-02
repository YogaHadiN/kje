<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staf extends Model{
	public $incrementing = false; 

	// Add your validation rules here
	public static $rules = [
		'nama' => 'required',
		'alamat_domisili' => 'required',
		'ktp' => 'required',
		'no_telp' => 'required'
	];

	// Don't forget to fill this array
	protected $guarded = [];

	public function periksa(){

		return $this->hasMany('App\Periksa');
	}

    public function jurnalUmums(){
         return $this->hasManyThrough('App\JurnalUmum', 'App\Periksa', 'staf_id', 'jurnalable_id');
    }
    
}
