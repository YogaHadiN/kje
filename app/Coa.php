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
		$saldo = $this->saldo_awal;
		$query = "SELECT sum( nilai ) as jumlah from jurnal_umums where coa_id = '{$coa_id}' and debit=1";
		$debit = DB::select($query )[0]->jumlah;
		$query = "SELECT sum( nilai ) as jumlah from jurnal_umums where coa_id = '{$coa_id}' and debit=0";
		$kredit = DB::select($query )[0]->jumlah;
		return abs($kredit - $debit) + $saldo;
	}
}
