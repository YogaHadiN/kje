<?php

namespace App;
use App\Coa;

use Illuminate\Database\Eloquent\Model;

class PembayaranAsuransi extends Model
{
    //
    public function asuransi(){
         return $this->belongsTo('App\Asuransi');
    }
    public function staf(){
         return $this->belongsTo('App\Staf');
    }
	public function coa(){
         return $this->belongsTo('App\Coa', 'kas_coa_id');
    }
    protected $dates = ['tanggal_dibayar', 'mulai', 'akhir', 'created_at'];
	protected $morphClass = 'App\PembayaranAsuransi';

    public function jurnals(){
        return $this->morphMany('App\JurnalUmum', 'jurnalable');
    }
    public function getKetjurnalAttribute(){
        $asuransi = Asuransi::find($this->asuransi_id)->nama;
        $pembayaran = $this->pembayaran;
        $tanggal = $this->tanggal_dibayar->format('d-m-Y');
        $kas = Coa::find($this->kas_coa_id)->coa;

        $pesan = 'Telah dibayarkan oleh <strong>' . $asuransi . '</strong><br /> sebesar <strong class="uang">' . $pembayaran . '</strong> pada tanggal <strong>' . $tanggal . '</strong><br /> ke <strong> ' . $kas . '</strong>';
        return $pesan;
    }
}
