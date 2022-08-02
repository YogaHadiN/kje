<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Input;
use App\Models\Sms;
use App\Models\SmsGagal;
use App\Models\Pasien;
use App\Models\Config;
use App\Models\Classes\Yoga;
use App\Models\SmsKontak;
use DB;

class smsAngkakontak extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:angkakontak';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'SMS tiap hari untuk meningkatkan angka kontak BPJS';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

		\Log::info('==============================================================================');
		\Log::info('================MEMULAI SMS BLAST BISMILLAH===============================');
		\Log::info('==============================================================================');
		$tanggal = date('Y-m');
		$jumlah_peserta_bpjs = Config::where('config_variable', 'jumlah_peserta_bpjs')->first()->value;

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
		$query.= "OR id in( Select pasien_id from periksas as prx join asuransis as asu on asu.id = prx.asuransi_id where asu.tipe_asuransi_id = 5 and prx.created_at like '{$tanggal}%' )) ";
		// Sehingga kita bisa mendapat angka kontak saat ini
		$query   .= "AND tenant_id = " . session()->get('tenant_id') . " ";
		$angka_kontak_saat_ini = DB::select($query)[0]->jumlah;

		
		// Kita asumsikan bahwa tanggal 1 itu belum bisa dihitung, jadi kita anggap tanggal 1 = tanggal 0, maka tanggal sekarang dikurangi 1
		$date = date('d') -1;

		// target angka kontak bulan ini adalah 31% dari jumlah peserta bpjs kita
		$target_bulan_ini = ceil( 26 / 100 * $jumlah_peserta_bpjs );
		// diharapkan target tersebut dipenuhi pada tanggal 26 setiap bulannya

		if ( $date > 27 ) {
			 $date = 27;
		}

		// Target yang harus kita capai hari ini adalah ( tanggal -1  ) / 27 hari target angka kontak tercapai
		$target_hari_ini = ceil( $target_bulan_ini * $date / 27 ) ;
		// Target berapa sms yang harus kita kirim hari ini adalah 
		// target berapa angka kontak hari ini dikurangi pencapaian angka kontak yang sudah kita capai hari sebelumnya
		// hasilnya adalah jumlah nomor yang harus kita sms hari ini
		$angka_kontak_kurang =  $target_hari_ini - $angka_kontak_saat_ini;
		// Jika angka kontak sudah tercapai sepenuhnya, maka kirim sebanyak 0 sms hari ini (jangan kirim sms)
		// Jika sekarang masih tanggal 1, jangan kirim sms, tunggu besok
		$angka_kontak_kurang = ( $angka_kontak_kurang > 0 ) ? $angka_kontak_kurang : 0;


		// Untuk menghitung berapa pasien yang harus kita kirim sms hari ini
		// ===================================================================
		//
		// kita hitung dulu jumlah pasien yang punya nomor asuransi bpjs
		// yang memiliki no_telp untuk kita kirim sms
		// yang termsuk pengantar yang sudah di masukkan pcare_submit
		// yang termsuk  sms_kontaks yang sudah di sms yang dimasukkan di pcare_submit
		// yang termsuk  pasien bpjs yang mengunakan Pembayaran non bpjs
		// yang termsuk  pasien bpjs yang mengunakan Pembayaran bpjs

		// Untuk menghitung berapa pasien yang harus kita kirim sms hari ini
		// ===================================================================
		$query = "SELECT id, replace( no_telp, ' ', '' ) as no_telp FROM pasiens ";
		// kita hitung dulu jumlah pasien yang punya nomor asuransi bpjs
		$query.= "WHERE nomor_asuransi_bpjs is not null ";
		// dikurangi pasien yang sudah masuk sebagai daftar pengantar yang sudah masuk di pcare
		$query.= "AND id not in( Select pengantar_id from pengantar_pasiens where created_at like '{$tanggal}%' and pcare_submit = 1 ) ";
		// dikurangi pasien yang memiliki nomor telepon sudah masuk sebagai daftar pengantar yang sudah kita BERHASIL sms
		$query.= "AND no_telp not in( Select ps.no_telp from sms_kontaks as sk join pasiens as ps on ps.id = sk.pasien_id where sk.created_at like '{$tanggal}%' ) ";
		// dikurangi pasien yang memiliki nomor telepon sudah masuk sebagai daftar pengantar yang sudah kita GAGAL sms
		$query.= "AND no_telp not in( Select ps.no_telp from sms_gagals as sk join pasiens as ps on ps.id = sk.pasien_id where sk.created_at like '{$tanggal}%' ) ";
		// dikurangi pasien BPJS yang berobat sebagai pembayaran non BPJS yang berhasil kita masukkan di pcare
		$query.= "AND id not in( Select px.pasien_id from kunjungan_sakits as ks join periksas as px on px.id = ks.periksa_id where ks.created_at like '{$tanggal}%' and ks.pcare_submit = 1 ) ";
		// dikurangi pasien BPJS yang berobat sebagai pembayaran BPJS yang berhasil kita masukkan di pcare
		$query.= "AND id not in( Select pasien_id from periksas as prx join asuransis as asu on asu.id = prx.asuransi_id where asu.tipe_asuransi_id = 5 and prx.created_at like '{$tanggal}%' ) ";
		// dikurangi pasien BPJS yang terdaftar di tabel sms_jangans;
		$query.= "AND id not in( Select pasien_id from sms_jangans ) ";
		// pilih pasien yang memiliki no_telp dengan awalan 08 atau +62 
		$query.= "AND ( no_telp like '08%' or no_telp like '+628%' ) ";
		// kita order by menurut no_telp, jangan sampai no_telp yang sama di sms 2 kali
		 $query.= "ORDER BY replace( no_telp, ' ', '' ) ";
		$query   .= "AND tenant_id = " . session()->get('tenant_id') . " ";
		// kita batasi sesuai target angka kontak hari ini supaya gak terlalu banyak yang disms dan memudahkan penginputan
		$query.= "LIMIT {$angka_kontak_kurang} ";


		$sms = DB::select($query);

		// kita akan buat array dimana satu array memiliki element string no_telp dan element array id, 
		// dimana satu nomor telepon memungkinkan memiliki lebih dari 1 id, 
		// jadi satu sms, bisa masuk ke 2 atau lebih inputa pcare
		
		$dataSms = [];
		foreach ($sms as $s) {
			$sama = false;
			foreach ($dataSms as $k => $sm) {
				if ($sm['no_telp'] == $s->no_telp) {
					$dataSms[$k]['id'][] = $s->id;
					$sama = true;
				}
			}
			if (!$sama) {
				$dataSms[] = [
					'id' => [$s->id],
					'no_telp' => $s->no_telp
				];
			}
		}

		$dataSms[]     = [
			'id'      => ['151013024'],
			'no_telp' => env('NO_HP_OWNER')
		];

		// pesan apa yang mau kita sms ada di dalam tabel configs , 
		$pesan = Config::where('config_variable', 'sms_blast_angka_kontak_bpjs')->first()->value;
		\Log::info('Isi Pesan : ');
		\Log::info($pesan);
		$timestamp = date('Y-m-d H:i:s');
		$data = [];
		$gagal = [];

		foreach ($dataSms as $value) {
			try {
				
				// Kita sms ke nomor satu per satu di looping sesuai query yang sudah kita buat
				Sms::send( str_replace(' ','', $value[ 'no_telp' ] ), $pesan);

				// Jika berhasil masukkan array data;
				// Karena satu nomor telepon bisa memiliki lebih dari satu pemilik, 
				// maka masukkan semua pasien_id yang memiliki nomor telepon tersebut
				if ($value['no_telp'] !=env('NO_HP_OWNER')) {
					foreach ($value['id'] as $val) {
						$data[] = [ 
							'pasien_id'  => $val,
							'tenant_id'  => session()->get('tenant_id'),
							'pesan'      => $pesan,
							'tenant_id'  => session()->get('tenant_id'),
							'created_at' => $timestamp,
							'updated_at' => $timestamp
						];
					}
				}
				\Log::info('pengiriman ke ' . $value[ 'no_telp' ] . ' BERHASIL dilakukan pada ' . date('d-m-Y H:i:s'));
			} catch (\Exception $e) {
				// Jika gagal masukkan array gagal;
				//
				if ($value['no_telp'] !=env('NO_HP_OWNER')) {
					foreach ($value['id'] as $val) {
						$gagal[] = [
							'pasien_id'  => $val,
							'pesan'      => $pesan,
							'tenant_id'  => session()->get('tenant_id'),
							'error'      => $e->getMessage(),
							'created_at' => $timestamp,
							'updated_at' => $timestamp
						];
					}
				}
				\Log::info('pengiriman ke ' . $value[ 'no_telp'  ]. ' GAGAL dilakukan pada ' . date('d-m-Y H:i:s'));
				\Log::info( $e->getMessage() );
			}
		}
		// masukkan semua yang berhasil (array data) ke tabel sms_kontaks
		\Log::info('Terkirim berhasil sebanyak : ');
		\Log::info( count($data) . ' sms' );
		SmsKontak::insert($data);
		// masukkan semua yang gagal (array gagal) ke tabel sms_gagals
		\Log::info('Terkirim gagal sebanyak : ');
		\Log::info( count($gagal) . ' sms' );

		SmsGagal::insert($gagal);
		Sms::send(env('NO_HP_OWNER'), 'Terkirim sebanyak ' . count($data) . ' sms, gagal sebanyak ' . count($gagal) . ' sms');
		\Log::info('==============================================================================');
		\Log::info('================MENGAKHIRI SMS BLAST ALHAMDULILLAH============================');
		\Log::info('==============================================================================');
    }
}
