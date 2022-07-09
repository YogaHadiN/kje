<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Prolanis extends Model
{
    use BelongsToTenant, HasFactory;
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
