<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AntrianPoli;
use DateTime;

class AntrianPoli extends Model{
		
	public $incrementing = false; 

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $dates = ['tanggal'];

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
	public function besokKonsulGigi(){
		$date = new DateTime(date('Y-m-d'));
		$date->modify('+1 day');
		$besok = $date->format('Y-m-d');

		return AntrianPoli::with('pasien')
						->where('tanggal', $besok)
						->where('poli', 'gigi')
						->get();
	}
	
}
