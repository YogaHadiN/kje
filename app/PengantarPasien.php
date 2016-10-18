<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PengantarPasien extends Model
{
    //
	public function pengantar(){
		return $this->belongsTo('App\Pasien', 'pengantar_id');
	}
}
