<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class GoPay extends Model
{
    use BelongsToTenant;
	protected $dates = ['tanggal'];
	public function pengeluaran(){
		return $this->belongsTo('App\Models\Pengeluaran');
	}
}
