<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\BelanjaPeralatan;
use App\Penyusutan;
use App\JurnalUmum;
use Log;

class JadwalPenyusutan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:penyusutan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Penyusutan Peralatan';

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
		Log::info('JadwalPenyusutan');
		Log::info('Saat ini ' . date('Y-m-d H:i:s'));
		Log::info('Seharusnya muncul tiap akhir bulan jam 15:00');

		$alats = BelanjaPeralatan::whereRaw('(( harga_satuan * jumlah ) - penyusutan) > 1')->get();
		$total_penyusutan = 0;
		$bulan = date('Y-m');
		foreach ($alats as $alat) {
			$penyusutan = round( ( $alat->harga_satuan * $alat->jumlah ) /(12*$alat->masa_pakai) );
			if ($penyusutan > ( ( $alat->harga_satuan * $alat->jumlah )  - $alat->penyusutan - $alat->jumlah )) {
				$penyusutan =  ( $alat->harga_satuan * $alat->jumlah )  - $alat->penyusutan -  $alat->jumlah ;
			}
			$alat->penyusutan = $alat->penyusutan + $penyusutan;
			$alat->save();
			$total_penyusutan += $penyusutan;
		}
		$susut       = new Penyusutan;
		$susut->penyusutan   = $total_penyusutan;
		$susut->tanggal_mulai = $bulan . '-01';
		$susut->tanggal_akhir = date("Y-m-t", strtotime($bulan . '-01'));
		$confirm = $susut->save();
		if ($confirm) {
			$jurnal                  = new JurnalUmum;
			$jurnal->jurnalable_id   = $susut->id; // id referensi yang baru dibuat
			$jurnal->jurnalable_type = 'App\Penyusutan';
			$jurnal->coa_id          = 612312; //Biaya Penyusutan
			$jurnal->debit           = 1;
			$jurnal->nilai           = $total_penyusutan;
			$jurnal->save();
			
			$jurnal                  = new JurnalUmum;
			$jurnal->jurnalable_id   = $susut->id;// id referensi yang baru dibuat
			$jurnal->jurnalable_type = 'App\Penyusutan';
			$jurnal->coa_id          = 120002; // Akumulasi Penyusutan Peralatan
			$jurnal->debit           = 0;
			$jurnal->nilai           = $total_penyusutan;
			$jurnal->save();
		}
    }
}
