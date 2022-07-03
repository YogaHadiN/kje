<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 
use App\Models\AntrianPoli;
use App\Http\Controllers\AntrianPolisController;
use DateTime;

class AntrianPoli extends Model{
    use BelongsToTenant;
		
	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $dates = ['tanggal'];

	public function staf(){

		return $this->belongsTo('App\Models\Staf');
	}
	public function antrian(){
        return $this->morphOne('App\Models\Antrian', 'antriable');
	}

	public function pasien(){

		return $this->belongsTo('App\Models\Pasien');
	}

	public function asuransi(){

		return $this->belongsTo('App\Models\Asuransi');
	}

    protected $morphClass = 'App\Models\AntrianPoli';
    public function antars(){
        return $this->morphMany('App\Models\PengantarPasien', 'antarable');
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

	public static function boot(){
		parent::boot();
		self::deleting(function($antrianpoli){
			$antrianpoli->antrian()->delete();
			$apc                     = new AntrianPolisController;
			$apc->updateJumlahAntrian(false, null);
		});
	}
}
