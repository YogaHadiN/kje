<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rak extends Model{

	// Add your validation rules here
	public $incrementing = false; 

	// Don't forget to fill this array
	protected $guarded = [];

	public function formula(){
		return $this->belongsTo('App\Formula');
	}

	public function merek(){
		return $this->hasMany('App\Merek');
	}
	public function getMereksAttribute(){

		$mereks = '';

		foreach ($this->merek as $merek) {
			$mereks .= $merek->merek . '<br>';
		}

		return $mereks;
	}
	public function getKomposisisAttribute(){

		$komposisis = '';

		foreach ($this->formula->komposisi as $komposisi) {
			$komposisis .= $komposisi->generik->generik . ' ' . $komposisi->bobot . '<br>';
		}

		return $komposisis;
	}
	public function getFornasnyaAttribute(){
		$fornas = $this->fornas;

		if ($fornas == '1') {
			return 'fornas';
		} else if($fornas == '2'){
			return 'non fornas';
		}

	}

}