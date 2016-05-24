<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model{
	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $guarded = [];


	public function tarif(){
		return $this->belongsTo('App\Tarif');
	}

}