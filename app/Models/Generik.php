<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Generik extends Model{
	public static function boot(){
		parent::boot();
		self::deleting(function($generik){
			$query  = "SELECT merek from mereks as mr ";
			$query .= "JOIN raks as rk on rk.id = mr.rak_id ";
			$query .= "JOIN formulas as fo on fo.id = rk.formula_id ";
			$query .= "JOIN komposisis as ko on fo.id = ko.formula_id ";
			$query .= "WHERE ko.generik_id = " . $generik->id;
			$data = DB::select($query);
			
			if ( count( $data ) > 0 ) {
				$pesan  = 'Tidak bisa menghapus generik ini karena masih menaungi merek : ';
				$pesan .= '<ul>';
				foreach ($data as $d) {
					$pesan .= '<li>' .$d->merek. '</li>';
				}
				$pesan .= '<ul>';
				Session::flash('pesan', Yoga::gagalFlash($pesan));
				return false;
			}
		});
	}

	public static function list(){
		return [ null => 'pilih' ] + Generik::pluck('generik', 'id')->all();
	}

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];

}
