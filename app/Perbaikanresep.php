<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perbaikanresep extends Model{

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];
	protected $table = 'perbaikanreseps';


	public function periksa(){

		return $this->belongsTo('App\Periksa');
	}

    public function getTerapihtml1Attribute(){
        $terapiJson = $this->terapi1;
        $terapiJson = json_decode($terapiJson,true);
        $temp = '<table class="table table-condensed table-bordered">';
		try {

			foreach ($terapiJson as $terapi) {
			   $temp .= '<tr>'; 
			   $temp .= '<td>' . Merek::find($terapi['merek_id'])->merek . '</td>';
			   $temp .= '<td>' . $terapi['jumlah'] . '</td>';
			   $temp .= '<td>' . $terapi['aturan_minum'] . '</td>';
			   $temp .= '</tr>'; 
			}
			
		} catch (\Exception $e) {

			foreach ([] as $terapi) {
			   $temp .= '<tr>'; 
			   $temp .= '<td>' . Merek::find($terapi['merek_id'])->merek . '</td>';
			   $temp .= '<td>' . $terapi['jumlah'] . '</td>';
			   $temp .= '<td>' . $terapi['aturan_minum'] . '</td>';
			   $temp .= '</tr>'; 
			}
		}
        $temp .= '</table>';
        return $temp;
    }
    public function getTerapihtml2Attribute(){
        $terapiJson = $this->terapi2;
        $terapiJson = json_decode($terapiJson,true);
        $temp = '<table class="table table-condensed table-bordered">';
		try {

			foreach ($terapiJson as $terapi) {
			   $temp .= '<tr>'; 
			   $temp .= '<tr>'; 
			   $temp .= '<td>' . Merek::find($terapi['merek_id'])->merek . '</td>';
			   $temp .= '<td>' . $terapi['jumlah'] . '</td>';
			   $temp .= '<td>' . $terapi['aturan_minum'] . '</td>';
			   $temp .= '</tr>'; 
			}
			
		} catch (\Exception $e) {

			foreach ([] as $terapi) {
			   $temp .= '<tr>'; 
			   $temp .= '<tr>'; 
			   $temp .= '<td>' . Merek::find($terapi['merek_id'])->merek . '</td>';
			   $temp .= '<td>' . $terapi['jumlah'] . '</td>';
			   $temp .= '<td>' . $terapi['aturan_minum'] . '</td>';
			   $temp .= '</tr>'; 
			}
		}
        $temp .= '</table>';
        return $temp;

    }
}
