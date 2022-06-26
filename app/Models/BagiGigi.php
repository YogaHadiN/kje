<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class BagiGigi extends Model
{
    use BelongsToTenant;
	protected $dates = ['mulai', 'akhir', 'tanggal_dibayar'];
	public function petugas(){
		return $this->belongsTo('App\Models\Staf', 'petugas_id');
	}
	public function getPeriodeAttribute(){
		return $this->tanggal_mulai->format('d-m-Y') . ' s/d ' . $this->tanggal_akhir->format('d-m-Y');
	}
    public function pph21s(){
        return $this->morphOne('App\Models\Pph21', 'pph21able');
    }
    public function jurnals(){
        return $this->morphMany(JurnalUmum::class, 'jurnalable');
    }
	public static function boot(){
		parent::boot();
		self::deleting(function($model){
			$model->pph21s()->delete();
			$model->jurnals()->delete();
		});
	}
	
}
