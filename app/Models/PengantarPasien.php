<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class PengantarPasien extends Model
{
    use BelongsToTenant;
    //
	protected $guarded = ['id'];
	public function pengantar(){
		return $this->belongsTo('App\Models\Pasien', 'pengantar_id');
	}

		
	
}
