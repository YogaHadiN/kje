<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Classes\Yoga;

class Penyusutan extends Model
{
    protected $morphClass = 'App\Penyusutan';
    protected $dates = [ 'tanggal_mulai', 'tanggal_akhir'  ];

    public function jurnals(){
        return $this->morphMany('App\JurnalUmum', 'jurnalable');
    }

    public function getKetjurnalAttribute(){

		$temp = 'Transaksi Penyusutan Peralatan <br>periode <strong>' . $this->tanggal_mulai->format('d-m-Y') . ' s/d ' . $this->tanggal_akhir->format('d-m-Y') . '</strong><br> senilai <strong>' . Yoga::buatrp( $this->penyusutan ) . '</strong>';

        return $temp;

    }
}
