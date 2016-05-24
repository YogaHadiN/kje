<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegisterAnc extends Model{

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

    public function registerHamil(){

        return $this->belongsTo('App\RegisterHamil');

    }

   	public function periksa(){

		return $this->belongsTo('App\Periksa');
	}

	public function kepalaTerhadapPap(){
		return $this->belongsTo('App\KepalaTerhadapPap');
	}
	public function Presentasi(){
		return $this->belongsTo('App\Presentasi');
	}
	public function statusGizi(){
		return $this->belongsTo('App\StatusGizi');
	}


	public function confirm_buku_kia(){
		return $this->belongsTo('App\Confirm', 'catat_di_kia');
	}

	public function refleksPatela(){
		return $this->belongsTo('App\RefleksPatela');
	}


}