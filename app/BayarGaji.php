<?php

namespace App;
use App\Staf;

use Illuminate\Database\Eloquent\Model;

class BayarGaji extends Model
{

    public function staf(){
         return $this->belongsTo('App\Staf');
    }
    public function coa(){
         return $this->belongsTo('App\Coa', 'kas_coa_id');
    }
    protected $morphClass = 'App\BayarGaji';
    protected $dates = ['tanggal_dibayar', 'mulai', 'akhir'];

    public function jurnals(){
        return $this->morphMany('App\JurnalUmum', 'jurnalable');
    }
    public function getKetjurnalAttribute(){
        $staf = Staf::find($this->staf_id)->nama;
        $pembayaran = $this->gaji_pokok + $this->bonus;
        $tanggal = $this->tanggal_dibayar->format('d-m-Y');
        $kas = Coa::find($this->kas_coa_id)->coa;

        $pesan = 'Telah dibayarkan kepada <strong>' . $staf . '</strong><br /> sebesar <strong class="uang">' . $pembayaran . '</strong> pada tanggal <strong>' . $tanggal . '</strong><br /> dengan sumber uang <strong> ' . $kas . '</strong>';
        return $pesan;
    }
    
}
