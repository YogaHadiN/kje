<?php

namespace App;

use App\Classes\Yoga;

use Illuminate\Database\Eloquent\Model;

class Pendapatan extends Model{
	// public $incrementing = false;  // hapus saja kalo mau increment

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $guarded = [];
	protected $dates = ['created_at'];
	public function staf(){

		return $this->belongsTo('App\Staf');
	}


    public function jurnals(){
        return $this->morphMany('App\JurnalUmum', 'jurnalable');
    }

    public function getKetjurnalAttribute(){
		$pendapatan = $this->pendapatan;
		$biaya      = $this->biaya;
		$keterangan = $this->keterangan;

		return 'Dibayarkan ' . $pendapatan . ' oleh ' . $keterangan . ' sebesar <span class="uang">' . $biaya . '</span>';
    }

}
