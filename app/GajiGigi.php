<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GajiGigi extends Model
{
	protected $dates = ['tanggal_mulai', 'tanggal_akhir'];
	public function staf(){
		return $this->belongsTo('App\Staf');
	}

	public function getPeriodeAttribute(){
		return $this->tanggal_mulai->format('d-m-Y') . ' s/d ' . $this->tanggal_akhir->format('d-m-Y');
	}
	
}
