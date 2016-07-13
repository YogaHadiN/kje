<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Classes\Yoga;

class Pengeluaran extends Model{
	protected $guarded = [];
	protected $with = ['supplier'];
	protected $dates = ['created_at', 'tanggal'];

    protected $morphClass = 'App\Pengeluaran';

	public function staf(){
		return $this->belongsto('app\staf');
	}
	public function fakturBelanja(){
		return $this->belongsto('App\FakturBelanja');
	}

	public function bukanObat(){
		return $this->belongsto('App\BukanObat');
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
			return 'Pembelanjaan <strong>' . $barang . '<br /></strong> di  :  <strong>' . $supplier . '</strong><br />sebesar <strong><span class="uang">' . $nilai . '</span><strong>';

    }
}
