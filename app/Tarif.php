<?php


namespace App;

use DB;
use App\BahanHabisPakai;

use Illuminate\Database\Eloquent\Model;

class Tarif extends Model{
	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $guarded = [ 'id' ];

	public function jenisTarif(){

		return $this->belongsTo('App\JenisTarif');

	}
	public function asuransi(){

		return $this->belongsTo('App\Asuransi');

	}

	public function tipeTindakan(){

		return $this->belongsTo('App\TipeTindakan');

	}

	public function getJenisTarifListAttribute(){
		return $this->jenisTarif->jenis_tarif;
	}

	public function getJenisbpjsAttribute(){
        if($this->biaya > 0){
		    return $this->jenisTarif->jenis_tarif . ' (TIDAK DITANGGUNG BPJS)';
        } else {
		    return $this->jenisTarif->jenis_tarif;
        }
	}

	public function getTarifJualAttribute(){

		$tarif_id = $this->id;
		$jenis_tarif_id = $this->jenis_tarif_id;
		$biaya = $this->biaya;

		$data = [
			'tarif_id' => $tarif_id,
			'jenis_tarif_id' => $jenis_tarif_id,
			'biaya' => $biaya
		];

		return json_encode($data);
	}
}
