<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Rekening extends Model
{
    use BelongsToTenant, HasFactory;
	protected $dates = [
		'tanggal'
	];
	public function akun_bank(){
		return $this->belongsTo('App\Models\AkunBank');
	}

	public function pembayaran_asuransi(){
		return $this->belongsTo('App\Models\PembayaranAsuransi');
	}
	
}
