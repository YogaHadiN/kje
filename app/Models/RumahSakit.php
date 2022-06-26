<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class RumahSakit extends Model{
    use BelongsToTenant;

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];


	public function bpjsCenter(){
		return $this->hasMany('App\Models\BpjsCenter');
    }
    
    public function tujuanRujuk(){
         return $this->belongsToMany('App\Models\TujuanRujuk', 'fasilitas');
    }

    public function getPicsAttribute(){
         $temp = '<ul id="tujuanRujuk">';
         foreach ($this->bpjsCenter as $pic) {
            $temp .= '<li>' . $pic->nama . ' (' . $pic->telp . ')' . '</li>';
         }
         $temp .= '</ul>';
         return $temp;
    }
    
}
