<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 

class SmsBpjs extends Model
{
    use BelongsToTenant;
	public function pasien(){
		return $this->belongsTo('App\Models\Pasien');
	}
	public static function angkaKontak($tahunBulan){
		// Untuk menghitung berapa pasien yang sudah masuk angka kontak kita, 
		// ===================================================================
		//
		// kita hitung dulu jumlah pasien yang punya nomor asuransi bpjs
		// yang termsuk pengantar yang sudah di masukkan pcare_submit
		// yang termsuk  sms_kontaks yang sudah di sms yang dimasukkan di pcare_submit
		// yang termsuk  pasien bpjs yang mengunakan Pembayaran non bpjs
		// yang termsuk  pasien bpjs yang mengunakan Pembayaran bpjs

		// Untuk menghitung berapa pasien yang sudah masuk angka kontak kita, 
		// ===================================================================
		$query = "SELECT DISTINCT count(*) as jumlah FROM pasiens ";
		// kita hitung dulu jumlah pasien yang punya nomor asuransi bpjs
		$query.= "WHERE nomor_asuransi_bpjs is not null ";
		// yang termsuk pengantar yang sudah di masukkan pcare_submit
		$query.= "AND (id in( Select pengantar_id from pengantar_pasiens where created_at like '{$tanggal}%' and pcare_submit = 1 )";
		// yang termsuk  sms_kontaks yang sudah di sms yang dimasukkan di pcare_submit
		$query.= "OR id in( Select pasien_id from sms_kontaks where created_at like '{$tanggal}%' and pcare_submit = 1 )";
		// yang termsuk  pasien bpjs yang mengunakan Pembayaran non bpjs
		$query.= "OR id in( Select px.pasien_id from kunjungan_sakits as ks join periksas as px on px.id = ks.periksa_id where ks.created_at like '{$tanggal}%' and ks.pcare_submit = 1 ) ";
		// yang termsuk  pasien bpjs yang mengunakan Pembayaran bpjs
		$query.= "OR id in( Select pasien_id from periksas where asuransi_id = 32 and created_at like '{$tanggal}%' )) ";
		// Sehingga kita bisa mendapat angka kontak saat ini
		$query .= "and tenant_id = " . session()->get('tenant_id') . " ";
		return DB::select($query)[0]->jumlah;
	}
}
