<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegisterHamil extends Model{

	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = [];


	public function pasien(){

		return $this->belongsTo('App\Pasien');
	}
	public function getNamagpaAttribute(){

		$nama = $this->pasien->nama;
		$g = $this->g;

		return $nama . ' kehamilan ke : ' . $g;

	}
	public function getRiwobsAttribute(){

		$json = $this->riwayat_persalinan_sebelumnya;
		$array = json_decode($json, true);
		$temp = '<table class="table table-condensed">';
		$temp .= '<thead>';
		$temp .= '<tr>';
		$temp .= '<th>Sex</th>';
		$temp .= '<th>Berat Lahir</th>';
		$temp .= '<th>Lahir Di</th>';
		$temp .= '<th>Cara</th>';
		$temp .= '</tr>';
		$temp .= '</thead>';
		$temp .= '<tbody>';

		if(count($array) > 0){

			foreach ($array as $key => $arr) {
				$temp .= '<tr>';
				$temp .= '<td>' . $arr['jenis_kelamin'] . '</td>';
				$temp .= '<td>' . $arr['berat_lahir'] . '</td>';
				$temp .= '<td>' . $arr['lahir_di'] . '</td>';
				$temp .= '<td>' . $arr['spontan_sc'] . '</td>';
				$temp .= '</tr>';
			}
		} else {
				$temp .= '<tr>';
				$temp .= '<td colspan="4">Hamil Ini</td>';
				$temp .= '</tr>';

		}
		$temp .= '</tbody></table>';


		return $temp;

	}

	
	public function buku(){
		return $this->belongsTo('App\Buku');
	}

}