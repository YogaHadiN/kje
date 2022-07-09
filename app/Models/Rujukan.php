<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Rujukan extends Model{
    use BelongsToTenant, HasFactory;

	// Don't forget to fill this array
	protected $fillable = [];
   // protected $table = 'rujukans';

   	public function tujuanRujuk(){

		return $this->belongsTo('App\Models\TujuanRujuk');
	}
   	public function periksa(){

		return $this->belongsTo('App\Models\Periksa');
	}
   	public function diagnosa(){

		return $this->belongsTo('App\Models\Diagnosa');
	}
   	public function rumahSakit(){

		return $this->belongsTo('App\Models\RumahSakit');
	}
   	public function registerHamil(){

		return $this->belongsTo('App\Models\RegisterHamil');
	}


}
