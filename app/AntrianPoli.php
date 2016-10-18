<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AntrianPoli extends Model{
		
	public $incrementing = false; 

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function staf(){

		return $this->belongsTo('App\Staf');
	}

	public function pasien(){

		return $this->belongsTo('App\Pasien');
	}

	public function asuransi(){

		return $this->belongsTo('App\Asuransi');
	}

    protected $morphClass = 'App\AntrianPoli';
    public function antars(){
        return $this->morphMany('App\PengantarPasien', 'antarable');
    }
}
