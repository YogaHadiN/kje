<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Rekening extends Model
{
    use BelongsToTenant;
    protected $primaryKey = 'id';
    public $incrementing = false;  // You most probably want this too
    protected $keyType = 'string';
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
