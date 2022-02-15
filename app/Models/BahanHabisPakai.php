<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BahanHabisPakai extends Model{
	protected $guarded = ['id'];


	public function jenisTarif(){

		return $this->belongsTo('App\Models\JenisTarif');
		
	}
	public function merek(){

		return $this->belongsTo('App\Models\Merek');
		
	}

	public function getListbhpAttribute(){
		$merek = $this->merek->merek;
		$jumlah = $this->jumlah;


		return $merek . ', ' . $jumlah;
	}
}
