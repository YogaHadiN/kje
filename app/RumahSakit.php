<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RumahSakit extends Model{

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];


	public function bpjsCenter(){
		return $this->hasMany('App\BpjsCenter');
    }
    
    public function tujuanRujuk(){
         return $this->belongsToMany('App\TujuanRujuk', 'fasilitas');
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
