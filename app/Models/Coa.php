<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use DB;

use App\Traits\BelongsToTenant; 
use Illuminate\Database\Eloquent\Model;
use App\Models\Coa;

class Coa extends Model{
    use BelongsToTenant, HasFactory;
    protected $guarded = [];

	public function kelompokCoa(){

		return $this->belongsTo('App\Models\KelompokCoa');
	}
	
	public function getCcoaAttribute(){
		return $this->id . ' - ' . $this->kelompok_coa;
	}
	public function getTotalAttribute(){
		$coa_id = $this->id;
		$kelompok_coa_id = $this->kelompok_coa_id;
		$saldo = $this->saldo_awal;
		$query = "SELECT sum( nilai ) as jumlah ";
		$query .= "from jurnal_umums ";
		$query .= "where coa_id = '{$coa_id}' ";
		$query .= "and debit=1 ";
		$query .= "and tenant_id = " . session()->get('tenant_id') . " ";
		$debit = DB::select($query )[0]->jumlah;

		$query = "SELECT sum( nilai ) as jumlah ";
		$query .= "from jurnal_umums ";
		$query .= "where coa_id = '{$coa_id}' ";
		$query .= "and debit=0 ";
		$query .= "and tenant_id = " . session()->get('tenant_id') . " ";
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
	public static function list(){
		return [ null => '-pilih-' ] + Coa::pluck('coa', 'id')->all();
	}

    public static function kasDiTangan(){
		return Coa::where('kode_coa', '110000')->first();
    }
}
