<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BayarDokter extends Model
{
    protected $with = ['staf'];
    //
    protected $dates = ['created_at', 'mulai', 'akhir'];
    public function staf(){
         return $this->belongsTo('App\Staf');
    }
    public function petugas(){
         return $this->belongsTo('App\Staf', 'petugas_id');
    }
    
    protected $morphClass = 'App\BayarDokter';
    public function jurnals(){
        return $this->morphMany('App\JurnalUmum', 'jurnalable');
    }
    public function getKetjurnalAttribute(){
        $tanggal = $this->created_at->format('d-m-Y');
        $uang = $this->bayar_dokter;
        $nama = $this->staf->nama;

        return 'Bayar <strong>' . $nama . ' </strong><br />sebesar <strong><span class="uang">' . $uang . '</span></strong><br /> pada tanggal<strong> ' . $tanggal . '</strong>';

    }
}
