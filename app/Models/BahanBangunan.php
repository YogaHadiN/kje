<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class BahanBangunan extends Model
{
    use BelongsToTenant;
	protected $guarded = [];
	protected $dates = ['tanggal_renovasi_selesai'];
	public function fakturBelanja(){
		return $this->belongsTo('App\Models\FakturBelanja');
	}
    protected $morphClass = 'App\Models\BahanBangunan';
    public function susuts(){
        return $this->morphMany('App\Models\Penyusutan', 'susutable');
    }
	public function getSudahSusutAttribute(){
		$susuts = $this->susuts;
		$nilai = 0;
		foreach ($susuts as $s) {
			$nilai += $s->nilai;
		}
		return $nilai;
	}
}
