<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class KunjunganSakit extends Model
{
    use BelongsToTenant, HasFactory;
	protected $guarded = ['id'];
	protected $dates = ['created_at'];

	public function periksa(){
		return $this->belongsTo('App\Models\Periksa');
	}
}
