<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Modal extends Model
{
    use BelongsToTenant, HasFactory;
    
    protected $dates = ['created_at'];
    public function coa(){
         return $this->belongsTo('App\Models\Coa');
    }
    public function staf(){
         return $this->belongsTo('App\Models\Staf');
    }
    
    protected $morphClass = 'App\Models\Modal';
    public function jurnals(){
        return $this->morphMany('App\Models\JurnalUmum', 'jurnalable');
    }
    public function getKetjurnalAttribute(){
        $tanggal = $this->created_at->format('d-m-Y');
        $uang = $this->modal;

        return 'Modal sebesar <strong><span class="uang">' . $uang . '</span></strong><br /> dimasukkan ke kasir pada tanggal <strong>' . $tanggal . '</strong>';

    }
}
