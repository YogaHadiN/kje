<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Classes\Yoga;

class JurnalUmum extends Model{

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];
	// Don't forget to fill this array
	protected $fillable = [];
	protected $dates = ['created_at', 'updated_at'];


	public function coa(){

		return $this->belongsTo('App\Models\Coa');
	}
	public function getTanggalAttribute(){
		$tanggal = explode(" ", $this->created_at);
		return Yoga::updateDatePrep($tanggal[0]);
	}

	public function jurnalable(){
		return $this->morphto();
	}
    
	public static function debitKredit(){
		return [
			null => ' - Pilih ',
			1    => 'Debit',
			0    => 'Kredit'
		];
	}

}
