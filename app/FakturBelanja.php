<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FakturBelanja extends Model{
		// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

    protected $morphClass = 'App\FakturBelanja';
	

	// Don't forget to fill this array
	protected $fillable = [];


	public function supplier(){

		return $this->belongsTo('App\Supplier');
	}
	public function staf(){

		return $this->belongsTo('App\Staf');
	}
	public function belanja(){

		return $this->belongsTo('App\Belanja');
	}

	public function pembelian(){

		return $this->hasMany('App\Pembelian');
	}

	public function pengeluaran(){

		return $this->hasMany('App\Pengeluaran');
	}
	public function getHargaAttribute(){
		$harga = 0;
		foreach ($this->pembelian as $pembelian) {
			$harga += $pembelian->jumlah * $pembelian->harga_beli;
		}

		return $harga;

	}

	public function getJumlahPengeluaranAttribute(){
		$harga = 0;
		foreach ($this->pengeluaran as $pengeluaran) {
			$harga += $pengeluaran->jumlah * $pengeluaran->harga_satuan;
		}

		return $harga;
	}
	public function getItemsAttribute(){
		$arr = $this->pembelian;
		return count($arr);
	}
	public function getTotalbiayaAttribute(){
		$arr = $this->pembelian;
		$biaya = 0;
		foreach ($arr as $k => $v) {
			$biaya += $v['harga_beli'] * $v['jumlah'];
		}

		return $biaya;
	}


    public function dispenses(){
        return $this->morphMany('App\Dispensing', 'dispensable');
    }
}