<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BelanjaPeralatan extends Model
{
	public function staf(){
		return $this->belongsTo('App\Staf');
	}
	public function fakturBelanja(){
		if ($this->faktur_belanja_id) {
			return $this->belongsTo('App\FakturBelanja');
		}
		return null;
	}
	
	
}
