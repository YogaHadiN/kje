<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BelanjaPeralatan extends Model
{
	protected $guarded = ['id'];
	public function staf(){
		return $this->belongsTo('App\Models\Staf');
	}
	public function fakturBelanja(){
		return $this->belongsTo('App\Models\FakturBelanja');
	}
    protected $morphClass = 'App\Models\BelanjaPeralatan';
	
    public function susuts(){
        return $this->morphMany('App\Models\Penyusutan', 'susutable');
    }
    public function getPenyusutanTotalAttribute(){
		$penyusutans = Penyusutan::where('susutable_id', $this->id)
								->where('susutable_type', 'App\Models\BelanjaPeralatan')
								->get();
		$nilai = 0;
		foreach ($penyusutans as $p) {
			$nilai += $p->nilai;
		}
		return $nilai;
    }
    public function getSudahSusutAttribute(){
		$penyusutans = $this->susuts;
		$nilai = 0;
		foreach ($penyusutans as $p) {
			$nilai += $p->nilai;
		}
		return $nilai;
    }
	
}
