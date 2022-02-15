<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GajiGigi extends Model
{
	protected $dates = ['mulai', 'akhir'];


	public function staf(){
		return $this->belongsTo('App\Models\Staf');
	}
	
	public function petugas(){
		return $this->belongsTo('App\Models\Staf', 'petugas_id');
	}

	public function getPeriodeAttribute(){
		return $this->mulai->format('d-m-Y') . ' s/d ' . $this->akhir->format('d-m-Y');
	}
	
    public function jurnals(){
        return $this->morphMany('App\Models\JurnalUmum', 'jurnalable');
    }
    public function getKetjurnalAttribute(){
		$temp = 'Pembayaran Gaji dokter gigi a/n <strong>';
		$temp .= $this->staf->nama . '</strong><br />';
		$temp .= 'dilakukan oleh <strong>'. $this->petugas->nama;
		$temp .= '<br /></strong>dibayar pada tanggal <strong>'. $this->tanggal_dibayar . '</strong>';
		return $temp;
    }

}
