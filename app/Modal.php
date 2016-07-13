<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modal extends Model
{
    
    protected $dates = ['created_at'];
    public function coa(){
         return $this->belongsTo('App\Coa', 'coa_kas_id');
    }
    public function staf(){
         return $this->belongsTo('App\Staf');
    }
    
    protected $morphClass = 'App\Modal';
    public function jurnals(){
        return $this->morphMany('App\JurnalUmum', 'jurnalable');
    }
    public function getKetjurnalAttribute(){
        $tanggal = $this->created_at->format('d-m-Y');
        $uang = $this->modal;

        return 'Modal sebesar <strong><span class="uang">' . $uang . '</span></strong><br /> dimasukkan ke kasir pada tanggal <strong>' . $tanggal . '</strong>';

    }
}
