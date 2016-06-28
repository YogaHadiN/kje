<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnosa extends Model{

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $guarded = [];

	public function periksa(){

		return $this->hasMany('App\Periksa');
	}
	public function icd10(){

		return $this->belongsTo('App\Icd10');
	}

	public function getDiagnosaIcdAttribute()
	{
	    return $this->diagnosa . ' - ' . $this->icd10->diagnosaICD . ' (' . $this->icd10_id. ')';
	}

	public function getDiagnosaIcddAttribute()
	{
		$icd = Icd10::find($this->icd10_id);
	    return $this->diagnosa . ' - ' . $icd->diagnosaICD . '</span>aaaaak (' . $icd->id. ')';
	}

}
