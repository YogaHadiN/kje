<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class RingkasanPenyusutan extends Model
{
    use BelongsToTenant;
	public function penyusutan(){
		return $this->hasMany('App\Models\Penyusutan');
	}
    public function getKetjurnalAttribute(){
		return $this->keterangan;

    }
	
    protected $morphClass = 'App\Models\RingkasanPenyusutan';
    public function jurnals(){
        return $this->morphMany('App\Models\JurnalUmum', 'jurnalable');
    }
}
