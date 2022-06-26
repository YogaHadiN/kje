<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class BayarDokter extends Model
{
    use BelongsToTenant;
    protected $with = ['staf'];
    //
    protected $dates = [
        'created_at', 
        'mulai', 
        'tanggal_dibayar', 
        'akhir'
    ];
    public function staf(){
         return $this->belongsTo('App\Models\Staf');
    }
    public function petugas(){
         return $this->belongsTo('App\Models\Staf', 'petugas_id');
    }
    
    protected $morphClass = 'App\Models\BayarDokter';
    public function jurnals(){
        return $this->morphMany('App\Models\JurnalUmum', 'jurnalable');
    }
    public function getKetjurnalAttribute(){
        $tanggal = $this->created_at->format('d-m-Y');
        $uang = $this->bayar_dokter;
        $nama = $this->staf->nama;

        return 'Bayar <strong>' . $nama . ' </strong><br />sebesar <strong><span class="uang">' . $uang . '</span></strong><br /> pada tanggal<strong> ' . $tanggal . '</strong>';

    }
    public function pph21s(){
        return $this->morphOne('App\Models\Pph21', 'pph21able');
    }
}
