<?php


namespace App\Models;

use App\Traits\BelongsToTenant; 
use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier;

class Supplier extends Model{
    use BelongsToTenant;

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $guarded = [];
	protected $dates = ['created_at'];


	public function Fakturbeli(){

		return $this->hasMany('Fakturbeli');
	}
	public static function list(){
		return [ null => '-Pilih-' ] + Supplier::pluck('nama', 'id')->all();
	}
	
    public function berkas(){
        return $this->morphMany('App\Models\Berkas', 'berkasable');
    }

}
