<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\JurnalUmum;

class perbaikiJurnal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jurnal:repair';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
		//=============================================================================
		//Pertama
		//=============================================================================
		$timestamp = '2016-12-13 22:30:31';

		$jurnals[] = [
			'jurnalable_id'   => '161213120',
			'jurnalable_type' => 'App\Periksa',
			'debit'           => 1,
			'nilai'           => 90000,
			'created_at'      => $timestamp,
			'coa_id'          => 110000, //Kas di tangan
			'updated_at'      => $timestamp,
		];

		$jurnals[] = [
			'jurnalable_id'   => '161213120',
			'jurnalable_type' => 'App\Periksa',
			'debit'           => 0,
			'nilai'           => 30000,
			'coa_id'          => 400001, // Pendapatan Jasa Dokter
			'created_at'      => $timestamp,
			'updated_at'      => $timestamp,
		];

		$jurnals[] = [
			'jurnalable_id'   => '161213120',
			'jurnalable_type' => 'App\Periksa',
			'debit'           => 0,
			'nilai'           => 50000,
			'coa_id'          => 400002, // Pendapatan Biaya Obat
			'created_at'      => $timestamp,
			'updated_at'      => $timestamp,
		];

		$jurnals[] = [
			'jurnalable_id'   => '161213120',
			'jurnalable_type' => 'App\Periksa',
			'debit'           => 0,
			'nilai'           => 10000,
			'coa_id'          => 400022, // Pendapatan Jam Malam
			'created_at'      => $timestamp,
			'updated_at'      => $timestamp,
		];

		$jurnals[] = [
			'jurnalable_id'   => '161213120',
			'jurnalable_type' => 'App\Periksa',
			'debit'           => 1,
			'nilai'           => 12000,
			'coa_id'          => 50201, // Biaya Produksi Jasa Dokter
			'created_at'      => $timestamp,
			'updated_at'      => $timestamp,
		];

		$jurnals[] = [
			'jurnalable_id'   => '161213120',
			'jurnalable_type' => 'App\Periksa',
			'debit'           => 0,
			'nilai'           => 12000,
			'coa_id'          => 200001, // Hutang Kepada Dokter
			'created_at'      => $timestamp,
			'updated_at'      => $timestamp,
		];

		$jurnals[] = [
			'jurnalable_id'   => '161213120',
			'jurnalable_type' => 'App\Periksa',
			'debit'           => 1,
			'nilai'           => 10790,
			'coa_id'          => 50204, // Biaya Produksi Obat
			'created_at'      => $timestamp,
			'updated_at'      => $timestamp,
		];

		$jurnals[] = [
			'jurnalable_id'   => '161213120',
			'jurnalable_type' => 'App\Periksa',
			'debit'           => 0,
			'nilai'           => 10790,
			'coa_id'          => 112000, // Persediaan Obat
			'created_at'      => $timestamp,
			'updated_at'      => $timestamp,
		];

		$jurnals[] = [
			'jurnalable_id'   => '161213120',
			'jurnalable_type' => 'App\Periksa',
			'debit'           => 1,
			'nilai'           => 1530,
			'coa_id'          => 50202, // Biaya Produksi Bonus Per Pasien
			'created_at'      => $timestamp,
			'updated_at'      => $timestamp,
		];

		$jurnals[] = [
			'jurnalable_id'   => '161213120',
			'jurnalable_type' => 'App\Periksa',
			'debit'           => 0,
			'nilai'           => 1530,
			'coa_id'          => 200002, // Hutang Bonus Karyawan
			'created_at'      => $timestamp,
			'updated_at'      => $timestamp,
		];
		//=============================================================================================
		// Kedua
		//=============================================================================================
		$timestamp = '2016-12-13 22:44:22';
		// Biaya produksi jasa dokter
		$jurnals[] = [
			'jurnalable_id'   => '161213121',
			'jurnalable_type' => 'App\Periksa',
			'debit'           => 1,
			'nilai'           => 5000,
			'coa_id'          => 50201,
			'created_at'      => $timestamp,
			'updated_at'      => $timestamp,
		];
		$jurnals[] = [
			'jurnalable_id'   => '161213121',
			'jurnalable_type' => 'App\Periksa',
			'debit'           => 0,
			'nilai'           => 5000,
			'coa_id'          => 200001,
			'created_at'      => $timestamp,
			'updated_at'      => $timestamp,
		];
		// Biaya produksi obat
		$jurnals[] = [
			'jurnalable_id'   => '161213121',
			'jurnalable_type' => 'App\Periksa',
			'debit'           => 1,
			'nilai'           => 5496,
			'coa_id'          => 50204,
			'created_at'      => $timestamp,
			'updated_at'      => $timestamp,
		];
		$jurnals[] = [
			'jurnalable_id'   => '161213121',
			'jurnalable_type' => 'App\Periksa',
			'debit'           => 0,
			'nilai'           => 5496,
			'coa_id'          => 112000,
			'created_at'      => $timestamp,
			'updated_at'      => $timestamp,
		];
		// Biaya produksi bonus asisten dokter
		$jurnals[] = [
			'jurnalable_id'   => '161213121',
			'jurnalable_type' => 'App\Periksa',
			'debit'           => 1,
			'nilai'           => 1530,
			'coa_id'          => 50202,
			'created_at'      => $timestamp,
			'updated_at'      => $timestamp,
		];
		$jurnals[] = [
			'jurnalable_id'   => '161213121',
			'jurnalable_type' => 'App\Periksa',
			'debit'           => 0,
			'nilai'           => 1530,
			'coa_id'          => 200002,
			'created_at'      => $timestamp,
			'updated_at'      => $timestamp,
		];

		JurnalUmum::insert($jurnals);
    }
}
