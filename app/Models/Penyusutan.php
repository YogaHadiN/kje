<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 
use App\Models\Classes\Yoga;

class Penyusutan extends Model
{
    use BelongsToTenant, HasFactory;
    protected $morphClass = 'App\Models\Penyusutan';
    protected $dates = [ 'tanggal_mulai', 'tanggal_akhir'  ];

    public function jurnals(){
        return $this->morphMany('App\Models\JurnalUmum', 'jurnalable');
    }
    public function getKetjurnalAttribute(){

		$temp = $this->keterangan;
		$temp .= '<br>periode <strong>' . $this->tanggal_mulai->format('d-m-Y') . ' s/d ' . $this->tanggal_akhir->format('d-m-Y') . '</strong><br> senilai <strong>' . Yoga::buatrp( $this->penyusutan ) . '</strong>';

        return $temp;

    }
	public function susutable(){
		return $this->morphto();
	}
	public function ringkasanPenyusutan(){
		return $this->belongsTo('App\Models\RingkasanPenyusutan');
	}
}
