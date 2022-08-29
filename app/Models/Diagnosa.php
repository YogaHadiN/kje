<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosa extends Model{
	// Add your validation rules here
    use HasFactory;
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $guarded = [];

	public function periksa(){
		return $this->hasMany('App\Models\Periksa');
	}
	public function icd10(){
		return $this->belongsTo('App\Models\Icd10');
	}


	public function getDiagnosaIcdAttribute()
	{
	    return $this->diagnosa . ' - ' . $this->icd10->diagnosaICD . ' (' . $this->icd10_id. ')';
	}
	public function getHarusDitanganiAttribute()
	{
		$icd_10 = $this->icd10;
		if ( Tidakdirujuk::where('icd10_id', $icd_10)->count()) {
			return true;
		}
		return false;
	}

	public function getDiagnosaIcddAttribute()
	{
		$icd = Icd10::find($this->icd10_id);
	    return $this->diagnosa . ' - ' . $icd->diagnosaICD . '</span>aaaaak (' . $icd->id. ')';
	}

}
