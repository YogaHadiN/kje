<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class Invoice extends Model
{
    use BelongsToTenant, HasFactory;

	public function pembayaran_asuransi(){
		return $this->belongsTo('App\Models\PembayaranAsuransi');
	}
	public function kirim_berkas(){
		return $this->belongsTo('App\Models\KirimBerkas');
	}
	public function periksa(){
		return $this->hasMany('App\Models\Periksa');
	}

	public function getDetailAttribute(){
		$periksas        = $this->periksa;
		$jumlah_tagihan = $periksas->count();
		$total_tagihan  = 0;

		$nama_asuransi     = $periksas->first()->asuransi->nama;

		foreach ($periksas as $pa) {
			$total_tagihan += $pa->piutang - $pa->sudah_dibayar;
		}

		return compact(
			'nama_asuransi',
			'jumlah_tagihan',
			'total_tagihan'
		);
	}
	public function getTanggalAkhirAttribute(){
		$piutang_asuransis = $this->piutang_asuransi;
		$dates = [];
		foreach ($piutang_asuransis as $pa) {
			$dates[] = strtotime($pa->periksa->tanggal);
		}
		rsort($dates);
		return date("Y-m-d", $dates[0]);
	}
	public function getTanggalMulaiAttribute(){
		$piutang_asuransis = $this->piutang_asuransi;
		$dates = [];
		foreach ($piutang_asuransis as $pa) {
			$dates[] = strtotime($pa->periksa->tanggal);
		}
		sort($dates);
		return date("Y-m-d", $dates[0]);
	}

	public function getDetailInvoiceAttribute(){
		$periksas = $this->periksa;
		$jumlah_tagihan    = $periksas->count();
		$total_tagihan     = 0;

		$nama_asuransi     = $periksas->first()->asuransi->nama;

		foreach ($periksas as $pa) {
			$total_tagihan += $pa->piutang - $pa->sudah_dibayar;
		}

		return compact(
			'nama_asuransi',
			'jumlah_tagihan',
			'total_tagihan'
		);
	}
}
