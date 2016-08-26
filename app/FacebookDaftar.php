<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacebookDaftar extends Model
{
	protected $dates = ['created_at', 'tanggal_lahir_pasien'];

	public function poli(){
		return $this->belongsTo('App\Poli', 'pilihan_poli');
	}
	

	public function getPembayaranAttribute(){
		$value = $this->pilihan_pembayaran;
		if ($value == 0) {
			return 'Biaya Pribadi';
		} elseif( $value == 1 ){
			return 'Asuransi Terdaftar di Pasien';
		} elseif( $value == 2 ){
			return 'Asuransi lain';
		}
	}
	
	public function getStatusBerobatAttribute($value){
		if ($value == 0) {
			return 'Belum Pernah Berobat';
		} else{
			return 'Sudah Pernah Berobat';
		}
	}
	
	
}
