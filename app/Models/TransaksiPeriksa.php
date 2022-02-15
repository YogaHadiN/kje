<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiPeriksa extends Model{
	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];
	protected $dates = ['created_at'];

	public function jenisTarif(){
		return $this->belongsTo('App\Models\JenisTarif');
	}
	public function periksa(){
		return $this->belongsTo('App\Models\Periksa');
	}
    public function getTanggalAttribute(){
         return $this->created_at->format('d-m-Y');
    }
    

}
