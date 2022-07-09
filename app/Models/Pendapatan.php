<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Classes\Yoga;
use App\Traits\BelongsToTenant; 

use Illuminate\Database\Eloquent\Model;

class Pendapatan extends Model{
    use BelongsToTenant, HasFactory;

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $guarded = [];
	protected $dates = ['created_at'];
	public function staf(){

		return $this->belongsTo('App\Models\Staf');
	}


    public function jurnals(){
        return $this->morphMany('App\Models\JurnalUmum', 'jurnalable');
    }

    public function getKetjurnalAttribute(){
		$sumber_uang = $this->sumber_uang;
		$biaya      = $this->nilai;
		$keterangan = $this->keterangan;

		return 'Dibayarkans <strong>' . $keterangan . '</strong><br /> oleh <strong>' . $sumber_uang . ' </strong><br />sebesar <strong><span class="uang">' . $biaya . '</span></strong>';
    }

}
