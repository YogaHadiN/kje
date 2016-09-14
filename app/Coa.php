<?php

namespace App;
use DB;

use Illuminate\Database\Eloquent\Model;

class Coa extends Model{
	public $incrementing = false; 

	public function kelompokCoa(){

		return $this->belongsTo('App\KelompokCoa');
	}
	
	public function getCcoaAttribute(){
		return $this->id . ' - ' . $this->kelompok_coa;
	}
	public function getTotalAttribute(){
		$coa_id = $this->id;
		$kelompok_coa_id = $this->kelompok_coa_id;
		$saldo = $this->saldo_awal;
		$query = "SELECT sum( nilai ) as jumlah from jurnal_umums where coa_id = '{$coa_id}' and debit=1";
		$debit = DB::select($query )[0]->jumlah;
		$query = "SELECT sum( nilai ) as jumlah from jurnal_umums where coa_id = '{$coa_id}' and debit=0";
		$kredit = DB::select($query )[0]->jumlah;
		if (
			$kelompok_coa_id == '10' ||
			$kelompok_coa_id == '11' ||
			$kelompok_coa_id == '12' ||
			$kelompok_coa_id == '5'
		) {
			return $debit - $kredit + $saldo;
		}else{
			return $kredit - $debit + $saldo;
		}
	}
}
