<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prolanis extends Model
{
	protected $guarded = ['id'];
	protected $table = 'prolanis';
	public function pasien(){
		return $this->belongsTo('App\Pasien');
	}
	public function getGolonganProlanisAttribute(){
		if ( $this->golongan_prolanis_id == '1' ) {
			return 'Hipertensi';
		} else {
			return 'Diabetes Mellitus';
		}
	}
	
}
