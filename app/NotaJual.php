<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotaJual extends Model{
	public $incrementing = false; 
	
	protected $fillable = [];

    protected $morphClass = 'App\NotaJual';

    public function penjualan(){
         return $this->hasMany('App\Penjualan');
    }
    

    public function dispenses(){
        return $this->morphMany('App\Dispensing', 'dispensable');
    }
    public function jurnals(){
        return $this->morphMany('App\JurnalUmum', 'jurnalable');
    }
    public function getKetjurnalAttribute(){

        $penjualans = $this->penjualan;
        $juals = '<ul>';
        $nilai = 0;
        foreach ($penjualans as $penj) {
            $merek = $penj->merek->merek;
            $juals .= '<li>' . $merek . '(' . $penj->jumlah . ' pcs), </li> ';
            $nilai += $penj->jumlah * $penj->harga_jual;
        }
        $juals .= '</ul>';
        return 'Penjualan ' .  $juals .  ' sebesar <span class="uang">' . $nilai . '</span>';

    }
}
