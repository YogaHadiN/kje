<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;
use App\Classes\Yoga;

class Staf extends Model{
	public $incrementing = false; 

	public static function boot(){
		parent::boot();
		self::deleting(function($staf){
			if ($staf->periksa->count() > 0) {
				Session::flash('pesan', Yoga::gagalFlash('Tidak bisa menghapus staf karena staf sudah pernah memeriksa pasien. Hubungi Super Admin untuk konfirmasi penghapusan'));
				return false;
			}
		});
	}
	// Add your validation rules here
	public static $rules = [
		'nama' => 'required',
		'alamat_domisili' => 'required',
		'ktp' => 'required',
		'no_telp' => 'required'
	];

	// Don't forget to fill this array
	protected $guarded = [];

	public function periksa(){

		return $this->hasMany('App\Periksa');
	}

    public function jurnalUmums(){
         return $this->hasManyThrough('App\JurnalUmum', 'App\Periksa', 'staf_id', 'jurnalable_id');
    }

    public function gaji(){
         return $this->hasMany('App\BayarGaji');
    }
    
}
