<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Kontrol;
use DateTime;

class Kontrol extends Model
{
	protected $dates = ['tanggal'];
	public function periksa(){
		return $this->belongsTo('App\Periksa');
	}
	public function besokKontrol(){
		$date			= new DateTime(date('Y-m-d'));
		$date->modify('+1 day');
		return Kontrol::with('periksa.pasien')
				->where('tanggal', $date->format('Y-m-d'))
				->get();
	}
	
}
