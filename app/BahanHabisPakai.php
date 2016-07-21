<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BahanHabisPakai extends Model{
	protected $guarded = ['id'];


	public function jenisTarif(){

		return $this->belongsTo('App\JenisTarif');
		
	}
	public function merek(){

		return $this->belongsTo('App\Merek');
		
	}

	public function getListbhpAttribute(){
		$merek = $this->merek->merek;
		$jumlah = $this->jumlah;


		return $merek . ', ' . $jumlah;
	}
}
