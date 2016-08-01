<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KelompokCoa extends Model{

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['id'];

	public function getTextListAttribute(){
		return $this->id . ' - ' . $this->kelompok_coa;
	}
	

}
