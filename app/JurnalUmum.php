<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Classes\Yoga;

class JurnalUmum extends Model{

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];


	public function coa(){

		return $this->belongsTo('App\Coa');
	}
	public function getTanggalAttribute(){
		$tanggal = explode(" ", $this->created_at);
		return Yoga::updateDatePrep($tanggal[0]);
	}

	public function jurnalable(){
		return $this->morphTo();
	}
    

}
