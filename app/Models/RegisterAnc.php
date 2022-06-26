<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class RegisterAnc extends Model{
    use BelongsToTenant;

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

    public function registerHamil(){

        return $this->belongsTo('App\Models\RegisterHamil');

    }

   	public function periksa(){

		return $this->belongsTo('App\Models\Periksa');
	}

	public function kepalaTerhadapPap(){
		return $this->belongsTo('App\Models\KepalaTerhadapPap');
	}
	public function Presentasi(){
		return $this->belongsTo('App\Models\Presentasi');
	}
	public function statusGizi(){
		return $this->belongsTo('App\Models\StatusGizi');
	}


	public function confirm_buku_kia(){
		return $this->belongsTo('App\Models\Confirm', 'catat_di_kia');
	}

	public function refleksPatela(){
		return $this->belongsTo('App\Models\RefleksPatela');
	}


}
