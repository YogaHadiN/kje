<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Classes\Yoga;

class Pengeluaran extends Model{
	protected $guarded = [];
	//protected $with = ['supplier'];
	protected $dates = ['created_at', 'tanggal'];

    protected $morphClass = 'App\Models\Pengeluaran';

	public function staf(){
		return $this->belongsto('App\Models\Staf');
	}


	public function supplier(){
		return $this->belongsTo('App\Models\Supplier');
	}
	public function sumberUang(){
		return $this->belongsTo('App\Models\Coa', 'sumber_uang_id');
	}

    public function jurnals(){
        return $this->morphMany('App\Models\JurnalUmum', 'jurnalable');
    }

    public function getKetjurnalAttribute(){
		$supplier = $this->supplier->nama;
        $barang = $this->keterangan;
		$nilai = $this->nilai;
			return 'Pembelanjaan <strong>' . $barang . '<br /></strong> di  :  <strong>' . $supplier . '</strong><br />sebesar <strong><span class="uang">' . $nilai . '</span><strong>';

    }

	public function getAdanotaAttribute(){
		if (!empty( $this->faktur_image )) {
			return 'ada nota';
		}
			return 'tidak ada nota';
	}
	public function getWarningnotaAttribute(){
		if (!empty( $this->faktur_image )) {
			return 'success';
		}
			return 'danger';
	}
	
	public function getBgnotaAttribute(){
		if (empty( $this->faktur_image )) {
			return 'warning';
		}
	}

}
