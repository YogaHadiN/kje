<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BayarDokter extends Model
{
    //
    protected $dates = ['created_at'];
    public function staf(){
         return $this->belongsTo('App\Staf');
    }
    
    protected $morphClass = 'App\BayarDokter';
    public function jurnals(){
        return $this->morphMany('App\JurnalUmum', 'jurnalable');
    }
    public function getKetjurnalAttribute(){
        $tanggal = $this->created_at->format('d-m-Y');
        $uang = $this->bayar_dokter;
        $nama = $this->staf->nama;

        return 'Bayar ' . $nama . ' sebesar <span class="uang">' . $uang . '</span> pada tanggal ' . $tanggal;

    }
}
