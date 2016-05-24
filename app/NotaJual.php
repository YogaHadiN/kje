<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotaJual extends Model{
	public $incrementing = false; 
	
	protected $fillable = [];

    protected $morphClass = 'App\NotaJual';

    public function dispenses(){
        return $this->morphMany('App\Dispensing', 'dispensable');
    }
}