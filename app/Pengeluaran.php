<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Classes\Yoga;

class Pengeluaran extends Model{
	public $incrementing = false; 
	
	protected $guarded = [];
	protected $dates = ['created_at', 'tanggal'];

    protected $morphClass = 'App\Pengeluaran';

	public function staf(){
		return $this->belongsTo('App\Staf');
	}

	public function supplier(){
		return $this->belongsTo('App\Supplier');
	}

    public function jurnals(){
        return $this->morphMany('App\JurnalUmum', 'jurnalable');
    }

    public function getKetjurnalAttribute(){
		$supplier = $this->supplier->nama;
        $barang = $this->keterangan;
		$nilai = $this->nilai;
        return 'Pembelanjaan ' . $barang . ' di  : ' . $supplier . ' sebesar ' . $nilai;
    }
}
