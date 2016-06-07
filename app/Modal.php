<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modal extends Model
{
    
    protected $morphClass = 'App\Modal';
    protected $dates = ['created_at'];
    public function coa(){
         return $this->belongsTo('App\Coa', 'coa_kas_id');
    }
    
    public function jurnals(){
        return $this->morphMany('App\JurnalUmum', 'jurnalable');
    }
    public function getKetjurnalAttribute(){
        $tanggal = $this->created_at->format('d-m-Y');
        $uang = $this->modal;

        return 'Modal sebesar <span class="uang">' . $uang . '</span> dimasukkan ke kasir pada tanggal ' . $tanggal;

    }
}
