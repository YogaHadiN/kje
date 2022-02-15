<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoPay extends Model
{
	protected $dates = ['tanggal'];
	public function pengeluaran(){
		return $this->belongsTo('App\Models\Pengeluaran');
	}
}
