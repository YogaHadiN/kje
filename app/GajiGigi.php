<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GajiGigi extends Model
{
	protected $dates = ['tanggal_mulai', 'tanggal_akhir'];


	public function staf(){
		return $this->belongsTo('App\Staf');
	}
	
	public function petugas(){
		return $this->belongsTo('App\Staf', 'petugas_id');
	}

	public function getPeriodeAttribute(){
		return $this->tanggal_mulai->format('d-m-Y') . ' s/d ' . $this->tanggal_akhir->format('d-m-Y');
	}
	
    public function jurnals(){
        return $this->morphMany('App\JurnalUmum', 'jurnalable');
    }
    public function getKetjurnalAttribute(){
		$temp = 'Pembayaran Gaji dokter gigi a/n <strong>';
		$temp .= $this->staf->nama . '</strong><br />';
		$temp .= 'dilakukan oleh <strong>'. $this->petugas->nama;
		$temp .= '<br /></strong>dibayar pada tanggal <strong>'. $this->tanggal_dibayar . '</strong>';
		return $temp;
    }

}
