<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PembayaranBpjs extends Model
{
	
    protected $morphClass = 'App\PembayaranBpjs';
	protected $dates = ['tanggal_pembayaran', 'mulai_tanggal', 'akhir_tanggal'];
	public function staf(){
		return $this->belongsTo('App\Staf');
	}
	
    public function jurnals(){
        return $this->morphMany('App\JurnalUmum', 'jurnalable');
    }

    public function getKetjurnalAttribute(){
		return 'Pembayaran Kapitasi BPJS periode ' . $this->mulai_tanggal->format('d-m-Y') . ' s/d ' .$this->akhir_tanggal->format('d-m-Y') . ' sebesar <strong class="uang">' .$this->nilai . '</strong>';
    }
}
