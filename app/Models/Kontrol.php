<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 
use App\Models\Kontrol;
use DateTime;

class Kontrol extends Model
{
    use BelongsToTenant, HasFactory;
	protected $dates = ['tanggal'];
	public function periksa(){
		return $this->belongsTo('App\Models\Periksa');
	}
	public function besokKontrol(){
		$date			= new DateTime(date('Y-m-d'));
		$date->modify('+1 day');
		return Kontrol::with('periksa.pasien')
				->where('tanggal', $date->format('Y-m-d'))
				->get();
	}
	
}
