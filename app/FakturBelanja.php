<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Classes\Yoga;

class FakturBelanja extends Model{
		// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

    protected $morphClass = 'App\FakturBelanja';

    protected $with = ['supplier'];

    protected $dates = ['tanggal'];


	

	// Don't forget to fill this array
	protected $fillable = [];


	public function supplier(){

		return $this->belongsTo('App\Supplier');
	}

	public function sumberUang(){

		return $this->belongsTo('App\Coa', 'sumber_uang_id');
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
	public function belanjaPeralatan(){

		return $this->hasMany('App\BelanjaPeralatan');
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
		$arr = [];
        if ($this->belanja->belanja == 'Belanja Obat') {
            $arr = $this->pembelian;
        }
		return count($arr);
	}
	public function getTotalbiayaAttribute(){

        if ($this->belanja->belanja == 'Belanja Obat') {
            $arr = $this->pembelian;
            $biaya = 0;
            foreach ($arr as $k => $v) {
                $biaya += $v['harga_beli'] * $v['jumlah'];
            }
		}else if ($this->belanja->belanja == 'belanja peralatan') {
			$arr=$this->belanjaPeralatan;
            $biaya = 0;
            foreach ($arr as $k => $v) {
                $biaya += $v['harga_satuan'] * $v['jumlah'];
            }

        } else {
            $arr = $this->pengeluaran;
            $biaya = 0;
            foreach ($arr as $k => $v) {
                $biaya += $v['harga_satuan'] * $v['jumlah'];
            }
        }
		return $biaya;
	}


    public function dispenses(){
        return $this->morphmany('App\Dispensing', 'dispensable');
    }

    public function jurnals(){
        return $this->morphMany('App\JurnalUmum', 'jurnalable');
    }

    public function getKetjurnalAttribute(){
		if ( $this->belanja_id == 4 ) {
			$total = 0;
			foreach ($this->belanjaPeralatan as $alat) {
				$total += $alat->nilai;
			}

			$temp = 'Pembelian Peralatan di <br><strong>';
			$temp .= $this->supplier->nama;
			$temp .= '<br></strong>sebesar <strong>';
			$temp .= Yoga::buatrp( $total ) . '</strong>';
			return $temp;
		}
        $tanggal = $this->tanggal->format('d-m-Y');
        $supplier = $this->supplier->nama;
        $total_pembelians = $this->pembelian;
        $total_pembelian = 0;
        foreach ($total_pembelians as $pembelian) {
            $total_pembelian += $pembelian->harga_beli * $pembelian->jumlah;
        }
        
        return 'Pembelian Obat di <strong>' . $supplier . '</strong><br /> sebesar :<strong><span class="uang">' . $total_pembelian . '</span></strong><br /> tanggal <strong>: ' . $tanggal . '</strong>';

    }
    
}

