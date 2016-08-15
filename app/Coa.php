<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coa extends Model{
	public $incrementing = false; 

	public function kelompokCoa(){

		return $this->belongsTo('App\KelompokCoa');
	}
	
	public function getCcoaAttribute(){
		return $this->id . ' - ' . $this->kelompok_coa;
	}
	
	
}
