<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant; 
use DB;

class SmsKontak extends Model
{
    use BelongsToTenant;
	protected $guarded = ['id'];
	protected $dates = ['created_at'];
	public function pasien(){
		return $this->belongsTo('App\Models\Pasien');
	}

	public static function angkaKontak($tahunBulan){

		$first_date_of_month = $tahunBulan ."-01";
		$last_date_of_month = date("Y-m-t", strtotime($first_date_of_month));
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
		//
		//
		$pasien_ids         = [];
		$pasien_ids_kemarin = [];
		$query  = "Select pengantar_id as id, pp.created_at as created_at ";
		$query .= "from pengantar_pasiens as pp ";
		$query .= "join pasiens as ps on ps.id = pp.pengantar_id ";
		$query .= "where pp.created_at between '{$first_date_of_month}' and '{$last_date_of_month}' ";
		$query .= "and pcare_submit = 1 ";
		$query .= "and nomor_asuransi_bpjs is not null ";
		$query .= "and pp.tenant_id = " . session()->get('tenant_id') . " ";
		$data = DB::select($query);

		foreach ($data as $d) {
			$pasien_ids[] = $d->id;
			if (strtotime($d->created_at) <= strtotime( date('Y-m-d 00:00:00') ) ) {
				$pasien_ids_kemarin[] = $d->id;
			}
		}

		$query  = "Select pasien_id as id , hv.created_at as created_at ";
		$query .= "from home_visits as hv ";
		$query .= "JOIN pasiens as ps on ps.id = hv.pasien_id ";
		$query .= "where hv.created_at between '{$tahunBulan}-01 00:00:00' and concat(last_day('{$tahunBulan}'), ' 23:59:59') ";
		$query .= "and nomor_asuransi_bpjs is not null ";
		$query .= "and hv.tenant_id = " . session()->get('tenant_id') . " ";
		$data = DB::select($query);

		foreach ($data as $d) {
			$pasien_ids[] = $d->id;
			if (strtotime($d->created_at) <= strtotime( date('Y-m-d 00:00:00') ) ) {
				$pasien_ids_kemarin[] = $d->id;
			}
		}

		$query  = " Select px.pasien_id as id , px.created_at as created_at ";
		$query .= "from kunjungan_sakits as ks ";
		$query .= "join periksas as px on px.id = ks.periksa_id ";
		$query .= "join pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where px.tanggal between '{$first_date_of_month}' and '{$last_date_of_month}' ";
		$query .= "and ks.pcare_submit = 1 ";
		$query .= "and ks.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and nomor_asuransi_bpjs is not null ";
		$data = DB::select($query);

		foreach ($data as $d) {
			$pasien_ids[] = $d->id;
			if (strtotime($d->created_at) <= strtotime( date('Y-m-d 00:00:00') ) ) {
				$pasien_ids_kemarin[] = $d->id;
			}
		}

		$first_date_of_month = $tahunBulan ."-01";
		$last_date_of_month = date("Y-m-t", strtotime($first_date_of_month));

		$query  = " Select pasien_id as id , px.created_at as created_at ";
		$query .= "from periksas as px ";
		$query .= "JOIN pasiens as ps on ps.id = px.pasien_id ";
		$query .= "where px.asuransi_id = 32 ";
		$query .= "and px.tanggal between '{$first_date_of_month}' and '{$last_date_of_month}' ";
		$query .= "and px.tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and nomor_asuransi_bpjs is not null ";
		$data = DB::select($query);

		foreach ($data as $d) {
			$pasien_ids[] = $d->id;
			if (strtotime($d->created_at) <= strtotime( date('Y-m-d 00:00:00') ) ) {
				$pasien_ids_kemarin[] = $d->id;
			}
		}
		return [
			'angka_kontak_saat_ini' => count(array_unique( $pasien_ids )),
			'angka_kontak_kemarin' => count(array_unique( $pasien_ids ))
		];


	}
	public static function angkaKontakSampaiKemarin(){

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

		$tahunBulan = date('Y-m');
		$hari_ini  = date('Y-m-d 00:00:00');

		$query     = "SELECT DISTINCT count(*) as jumlah FROM pasiens ";
		// kita hitung dulu jumlah pasien yang punya nomor asuransi bpjs
		$query    .= "WHERE nomor_asuransi_bpjs is not null ";
		// yang termsuk pengantar yang sudah di masukkan pcare_submit
		$query    .= "AND (id in( Select pengantar_id from pengantar_pasiens where created_at between '{$tahunBulan}-01' and '{$hari_ini}' and pcare_submit = 1 )";
		// yang termsuk  sms_kontaks yang sudah di sms yang dimasukkan di pcare_submit
		$query    .= "OR id in( Select pasien_id from sms_kontaks where created_at between '{$tahunBulan}-01' and '{$hari_ini}' and pcare_submit = 1 )";
		// yang termsuk  pasien bpjs yang mengunakan Pembayaran non bpjs
		$query    .= "OR id in( Select px.pasien_id from kunjungan_sakits as ks join periksas as px on px.id = ks.periksa_id where ks.created_at between '{$tahunBulan}-01' and '{$hari_ini}' and ks.pcare_submit = 1 ) ";
		// yang termsuk  pasien bpjs yang mengunakan Pembayaran bpjs
		$query    .= "OR id in( Select pasien_id from periksas where asuransi_id = 32 and created_at between '{$tahunBulan}-01' and '{$hari_ini}' )) ";
		// Sehingga kita bisa mendapat angka kontak saat ini
		$query .= "and tenant_id = " . session()->get('tenant_id') . " ";
		return DB::select($query)[0]->jumlah;
	}
}
