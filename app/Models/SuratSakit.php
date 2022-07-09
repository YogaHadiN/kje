<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\BelongsToTenant; 
use Illuminate\Database\Eloquent\Model;

class SuratSakit extends Model{
    use BelongsToTenant, HasFactory;
	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $guarded = [];


	public function periksa(){
		return $this->belongsTo('App\Models\Periksa');
	}

	public function getAkhirAttribute(){
		$tanggal = $this->tanggal_mulai;
		$hari = $this->hari;
		$str = strtotime($tanggal);
		$akhir = $str + (($hari -1) * 86400);
		if ($hari < 2) {
			$return = '--';
		} else {
			$return = date('d-m-Y', $akhir);
		}

		return $return;
	}
}
