<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Coa;
use App\JenisTarif;
use App\Asuransi;
use App\Tarif;

class dbInsertDiskon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:insertDiskon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'insert persiapan diskon';

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

		$coa               = new Coa;
		$coa->id           = 503000;
		$coa->coa = 'diskon';
		$coa->kelompok_coa_id = 5;
		$coa->saldo_awal   = 0;
		$confirm           = $coa->save();

		$t                           = new JenisTarif;
		$t->jenis_tarif              = 'diskon';
		$t->tipe_laporan_admedika_id = 1;
		$t->tipe_laporan_kasir_id    = 24;
		$t->coa_id                   = 503000;
		$t->dengan_asisten           = 0;
		$confirm                     = $t->save();

		$tu   = JenisTarif::find($t->id);
		$tu->id = 0;
		$tu->save();

		$asuransis = Asuransi::all();
		$data                       = [];
		$timestamp = date('Y-m-d H:i:s');
		
		foreach ($asuransis as $a) {
			$data[]                 = [
				'jenis_tarif_id'   => 0,
				'biaya'            => 0,
				'asuransi_id'      => $a->id,
				'jasa_dokter'      => 0,
				'tipe_tindakan_id' => 1,
				'bhp_items'        => '[]',
				'created_at'	=> $timestamp,
				'updated_at'	=> $timestamp
			];
		}
		Tarif::insert($data);

    }
}
