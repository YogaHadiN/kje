<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class BahanHabisPakai extends Model{
    use BelongsToTenant;
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
