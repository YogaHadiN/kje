<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToTenant; 
class KirimBerkas extends Model
{
    use BelongsToTenant;
	protected $dates = [
		'tanggal'
	];
	public function petugas_kirim(){
		return $this->hasMany('App\Models\PetugasKirim');
	}

	public function pengeluaran(){
		return $this->belongsTo('App\Models\Pengeluaran');
	}
	public function invoice(){
		return $this->hasMany('App\Models\Invoice');
	}

	public function getRekapTagihanAttribute(){
		$invoices = $this->invoice;
		$data              = [];
		foreach ($invoices as $invoice) {
			foreach ($invoice->periksa as $piutang) {
				$data[ $piutang->asuransi->nama ][] = $piutang;
			}
		}
		$data2 = [];
		foreach ($data as $k => $dt) {
			$total_tagihan = 0;
			$jumlah_tagihan = count($dt);
			foreach ($dt as $d) {
				$total_tagihan += $d->piutang - $d->sudah_dibayar;
			}
			$data2[ $k ] = [
				'nomor_invoice' => $d->invoice_id,
				'jumlah_tagihan' => $jumlah_tagihan,
				'total_tagihan' => $total_tagihan
			];
		}
		return $data2;
	}
	public function getPiutangTercatatAttribute(){
		$invoices = $this->invoice;
		$data     = [];
		foreach ($invoices as $invoice) {
			foreach ($invoice->periksa as $piutang) {
				$data[] = [
					'piutang_id'    => $piutang->id,
					'piutang'       => $piutang->piutang,
					'sudah_dibayar' => $piutang->sudah_dibayar,
					'periksa_id'    => $piutang->id,
					'nama_pasien'   => $piutang->pasien->nama,
					'nama_asuransi' => $piutang->asuransi->nama
				];
			}
		}
		return json_encode($data);
	}
	public function getIdViewAttribute(){
		return str_replace('/', '!', $this->id);
	}
}
