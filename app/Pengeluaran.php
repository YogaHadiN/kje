<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Classes\Yoga;

class Pengeluaran extends Model{
	public $incrementing = false; 
	
	protected $guarded = [];

    protected $morphClass = 'App\Pengeluaran';

	public function staf(){
		return $this->belongsTo('App\Staf');
	}

	public function nota_beli(){
		return $this->belongsTo('App\Notabeli');
	}

	public function supplier(){
		return $this->belongsTo('App\Supplier');
	}

	public function bukanObat(){
		return $this->belongsTo('App\BukanObat');
	}

	public function fakturBelanja(){
		return $this->belongsTo('App\FakturBelanja');
	}

    public function jurnals(){
        return $this->morphMany('App\JurnalUmum', 'jurnalable');
    }

    public function getKetjurnalAttribute(){
		$supplier = $this->fakturBelanja->supplier->nama;
        $barang = $this->bukanObat->nama;
        return 'Pembelanjaan ' . $barang . ' di  : ' . $supplier;
    }
}
