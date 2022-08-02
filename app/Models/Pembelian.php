<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Pembelian extends Model{
    use BelongsToTenant, HasFactory;
						
	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $guarded = [];

	public function merek(){

		return $this->belongsTo('App\Models\Merek');
	}
	public function fakturBelanja(){

		return $this->belongsTo('App\Models\FakturBelanja');
	}

    protected $morphClass = 'App\Models\Pembelian';
    public function dispens(){
        return $this->morphMany('App\Models\Dispensing', 'dispensable');
    }

}
