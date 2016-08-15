<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;
use App\Classes\Yoga;

class Pasien extends Model{
	public static function boot(){
		parent::boot();
		self::deleting(function($pasien){
			if ($pasien->periksa->count() > 0) {
				Session::flash('pesan', Yoga::gagalFlash('Tidak bisa menghapus pasien karena sudah ada pemeriksaan sebelumnya'));
				return false;
			}
			if ($pasien->antrianPeriksa->count() > 0 || $pasien->antrianPoli->count() > 0) {
				Session::flash('pesan', Yoga::gagalFlash('Tidak bisa menghapus pasien karena pasien sedang ada dalam antrian'));
				return false;
			}
		});
	}
	
	public $incrementing = false; 

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $guarded = [];

	public function asuransi(){

		return $this->belongsTo('App\Asuransi');
	}

	public function periksa(){

		return $this->hasMany('App\Periksa');
	}

	public function antrianPeriksa(){

		return $this->hasMany('App\AntrianPeriksa');
	}
	public function antrianPoli(){

		return $this->hasMany('App\AntrianPoli');
	}

	public function registerHamil(){

		return $this->hasMany('App\RegisterHamil');
	}
	public function getNamaAttribute($nama){
		return ucwords( strtolower($nama) );
	}
	public function getAlamatAttribute($alamat){

		return ucwords( strtolower($alamat) );

	}

	public function setNamaAttribute($value) {

        $this->attributes['nama'] = strtolower($value);

    }
	public function setAlamatAttribute($value) {

        $this->attributes['alamat'] = strtolower($value);

    }
}
