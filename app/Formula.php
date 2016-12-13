<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;
use App\Classes\Yoga;
use DB;

class Formula extends Model{
	public static function boot(){
		parent::boot();
		self::deleting(function($formula){
			if ($formula->rak->count() > 0) {
				$text = 'Tidak bisa menghapus karena formula ini masih memiliki rak berikut di bawahnya : ';
				$text .= '<ul>';
				foreach ($formula->rak as $rak) {
					$text .= '<li>' . $rak->id . ' dengan merek ';
					foreach ($rak->merek as $merek) {
						$text .= $merek->merek . ', ';
					}
					$text .= '</li>';
				}
				$text .= '</ul>';
				Session::flash('pesan', Yoga::gagalFlash($text));
				return false;
			}
			
		});
	}

	public $incrementing = false; 

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

	public function dose(){
		return $this->hasMany('App\Dose');
	}
	public function aturanMinum(){
		return $this->belongsTo('App\AturanMinum');
	}

	public function komposisi(){
		return $this->hasMany('App\Komposisi');
	}

	public function rak(){
		return $this->hasMany('App\Rak');
	}

	public function existing_komposisi($id){
		return DB::select("select * from komposisis as k left outer join generiks as g on g.id = k.generik_id where formula_id = $id");
	}

	public function getEndfixAttribute(){
		$sumKomposisi = $this->komposisi->count();
		$sediaan = $this->sediaan;

		if($sumKomposisi == 1){
			$bobot = $this->komposisi->first()->bobot;
			$endfix = $sediaan . ' ' . $bobot;
		} else {
			$endfix = $sediaan;
		}

		return $endfix;
	}

	public function getMerekBanyakAttribute(){
		$raks = $this->rak;
		$data = [];
		foreach ($raks as $key => $rak) {
			foreach ($rak->merek as $key => $mer) {
				$data[] = $mer->id;
			}
		}
		return $data;
	}

}
