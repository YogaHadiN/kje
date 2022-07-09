<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class NotaBeli extends Model{
    use BelongsToTenant, HasFactory;
	
	protected $fillable = [];
	protected $guarded = [];


	public function staf(){

		return $this->belongsTo('App\Models\Staf');
	}
	public function supplier(){

		return $this->belongsTo('App\Models\Supplier');
	}
}
