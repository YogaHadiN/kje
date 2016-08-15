<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GajiGigi extends Model
{
	protected $dates = ['tanggal_mulai', 'tanggal_akhir'];
	public function staf(){
		return $this->belongsTo('App\GajiGigi');
	}

	public function getPeriodeAttribute(){
		return $this->tanggal_mulai->format('d-m-Y') . ' s/d ' . $this->tanggal_akhir->format('d-m-Y');
	}
	
    public function getKetjurnalAttribute(){
		$temp = 'Pembayaran Gaji dokter gigi a/n ';
		$temp .= $this->staf->nama . '</strong><br />';
		$temp .= 'dilakukan oleh ' $this->petugas->nama;
		$temp .= '<br />dibayar pada tanggal' $this->tanggal_dibayar;
		return $temp;
    }

}
