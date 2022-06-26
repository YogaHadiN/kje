<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class PembayaranBpjs extends Model
{
    use BelongsToTenant;
	
    protected $morphClass = 'App\Models\PembayaranBpjs';
	protected $dates = ['tanggal_pembayaran', 'mulai_tanggal', 'akhir_tanggal'];
	public function staf(){
		return $this->belongsTo('App\Models\Staf');
	}
	
    public function jurnals(){
        return $this->morphMany('App\Models\JurnalUmum', 'jurnalable');
    }

    public function getKetjurnalAttribute(){
		return 'Pembayaran Kapitasi BPJS periode ' . $this->mulai_tanggal->format('d-m-Y') . ' s/d ' .$this->akhir_tanggal->format('d-m-Y') . ' sebesar <strong class="uang">' .$this->nilai . '</strong>';
    }
}
