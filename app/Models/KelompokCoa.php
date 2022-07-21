<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class KelompokCoa extends Model{
    use HasFactory;

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = ['id'];

	public function getTextListAttribute(){
		return $this->id . ' - ' . $this->kelompok_coa;
	}
	
	public function getCcoaAttribute(){
		return $this->id . ' - ' . $this->kelompok_coa;
	}
	public static function list(){
		return [ null => ' - pilih - ' ] + KelompokCoa::orderBy('id')->get()->pluck('ccoa', 'id')->all();
	}
}
