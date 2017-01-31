<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rujukan extends Model{

	// Don't forget to fill this array
	protected $fillable = [];


   // protected $table = 'rujukans';

   	public function tujuanRujuk(){

		return $this->belongsTo('App\TujuanRujuk');
	}

   	public function periksa(){

		return $this->belongsTo('App\Periksa');
	}
   	public function diagnosa(){

		return $this->belongsTo('App\Diagnosa');
	}
   	public function rumahSakit(){

		return $this->belongsTo('App\RumahSakit');
	}
   	public function registerHamil(){

		return $this->belongsTo('App\RegisterHamil');
	}


}
