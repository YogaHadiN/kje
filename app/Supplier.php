<?php


namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Supplier;

class Supplier extends Model{

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
		return [ null => '-Pilih-' ] + Supplier::lists('nama', 'id')->all();
	}
	

}
