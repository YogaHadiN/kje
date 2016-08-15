<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\BelanjaPeralatan;
use App\Penyusutan;
use App\JurnalUmum;

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
		$alats = BelanjaPeralatan::whereRaw('(nilai - penyusutan) > 1')->get();
		$total_penyusutan = 0;
		$bulan = date('Y-m');
		foreach ($alats as $alat) {
			$penyusutan = round( $alat->nilai/(12*$alat->masa_pakai) );
			if ($penyusutan > ( $alat->nilai - $alat->penyusutan -1 )) {
				$penyusutan =  $alat->nilai - $alat->penyusutan - 1 ;
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
			$jurnal->coa_id          = 800001; //Beban Penyusutan
			$jurnal->debit           = 1;
			$jurnal->nilai           = $total_penyusutan;
			$jurnal->save();
			
			$jurnal                  = new JurnalUmum;
			$jurnal->jurnalable_id   = $susut->id;// id referensi yang baru dibuat
			$jurnal->jurnalable_type = 'App\Penyusutan';
			$jurnal->coa_id          = 120001; // Peralatan
			$jurnal->debit           = 0;
			$jurnal->nilai           = $total_penyusutan;
			$jurnal->save();
		}
    }
}
