<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class InputHarta extends Model
{
    use BelongsToTenant;
	protected $dates= ['tanggal_beli'];
	public function statusHarta(){
		return $this->belongsTo('App\Models\StatusHarta');
	}
    public function susuts(){
        return $this->morphMany('App\Models\Penyusutan', 'susutable');
    }
}
