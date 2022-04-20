<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prolanis extends Model
{
	protected $guarded = ['id'];
	protected $table = 'prolanis';
	public function pasienProlanis(){
		return $this->hasMany('App\Models\PasienProlanis');
	}
	public function getGolonganProlanisAttribute(){
		if ( $this->golongan_prolanis_id == '1' ) {
			return 'Hipertensi';
		} else {
			return 'Diabetes Mellitus';
		}
	}
	
}
