<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Session;
use App\Classes\Yoga;

class Rak extends Model{

	public static function boot(){
		parent::boot();
		self::deleting(function(){
			if ($this->merek->count() > 0) {
				$pesan = 'Tidak bisa menghapus rak ini karena rak masih menaungi merek2 berikut ini : ';
				$pesan .= '<ul>';
				foreach ($this->merek as $merek) {
					$pesan .= '<li>' . $merek->merek . '</li>';
				}
				$pesan .= '</ul>';
				Session::flash('pesan', Yoga::gagalFlash($pesan));
				return false;
			}
		});
	}
	

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
