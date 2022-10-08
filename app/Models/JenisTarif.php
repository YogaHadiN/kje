<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class JenisTarif extends Model{
    use HasFactory, BelongsToTenant;

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function tarif(){

		return $this->hasMany('App\Models\Tarif');
		
	}
	public function bahanHabisPakai(){

		return $this->hasMany('App\Models\BahanHabisPakai');
		
	}
	public function bhp(){

		return $this->hasMany('App\Models\BahanHabisPakai');
		
	}

    public function coa(){
        return $this->belongsTo(Coa::class);
    }
    

}
