<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BagiGigi extends Model
{
    //
	protected $dates = ['tanggal_mulai', 'tanggal_akhir', 'tanggal_dibayar'];
	public function petugas(){
		return $this->belongsTo('App\Staf', 'petugas_id');
	}

	public function getPeriodeAttribute(){
		return $this->tanggal_mulai->format('d-m-Y') . ' s/d ' . $this->tanggal_akhir->format('d-m-Y');
	}
}
