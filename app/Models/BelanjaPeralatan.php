<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class BelanjaPeralatan extends Model
{
    use BelongsToTenant, HasFactory;
	protected $guarded = ['id'];
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
