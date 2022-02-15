<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengantarPasien extends Model
{
    //
	protected $guarded = ['id'];
	public function pengantar(){
		return $this->belongsTo('App\Models\Pasien', 'pengantar_id');
	}

		
	
}
