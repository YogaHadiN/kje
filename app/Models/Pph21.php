<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Pph21 extends Model
{
    use BelongsToTenant;
	protected $guarded = ['id'];
	public function pph21able(){
		return $this->morphto();
	}
	public function getTotalBrutoAttribute(){

		$gaji_bruto_bulan_ini = json_decode($this->ikhtisar_gaji_bruto, true);
		$total_bayar_bulan_ini = 0;
		foreach ( $gaji_bruto_bulan_ini as $g) {
			$total_bayar_bulan_ini += $g['gaji_bruto'];
		}
		return $total_bayar_bulan_ini;
	}

	public function getTotalPph21Attribute(){

		$gaji_bruto_bulan_ini = json_decode($this->ikhtisar_gaji_bruto, true);
		$total_bayar_bulan_ini = 0;
		foreach ( $gaji_bruto_bulan_ini as $g) {
			$total_bayar_bulan_ini += $g['pph21'];
		}
		return $total_bayar_bulan_ini;
	}

	public function getTotalBayarAttribute(){

		$gaji_bruto_bulan_ini = json_decode($this->ikhtisar_gaji_bruto, true);
		$total_bayar_bulan_ini = 0;
		foreach ( $gaji_bruto_bulan_ini as $g) {
			$total_bayar_bulan_ini += $g['gaji_bruto'] - $g['pph21'];
		}
		return $total_bayar_bulan_ini;
	}

}
