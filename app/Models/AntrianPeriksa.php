<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AntrianPeriksa extends Model{
	// Add your validation rules here
	public static $rules = [
		'asuransi_id' => 'required',
		'pasien_id' => 'required',
		'staf_id' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function asuransi() {
		return $this->belongsTo('App\Models\Asuransi');
	}
	public function ispoli() {
		return $this->belongsTo('App\Models\Poli', 'poli');
	}
	public function antrian(){
        return $this->morphOne(Antrian::class, 'antriable');
	}
	public function pasien() {
		return $this->belongsTo('App\Models\Pasien');
	}
    protected $morphClass = 'App\Models\AntrianPeriksa';
    public function antars(){
        return $this->morphMany('App\Models\PengantarPasien', 'antarable');
    }
	public function staf() {
		return $this->belongsTo('App\Models\Staf');
	}
	public function perujuk(){
		return $this->belongsTo('App\Models\Perujuk');
	}
	public function periksaEx(){
		return $this->hasOne('App\Models\Periksa', 'antrian_periksa_id', 'id');
	}
    public function gambars(){
        return $this->morphMany('App\Models\GambarPeriksa', 'gambarable');
    }

}
