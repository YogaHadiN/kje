<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PembayaranAsuransi;
use App\Models\JurnalUmum;
use App\Models\NotaJual;
use App\Models\PiutangDibayar;
use DB;

class revertPembayaranAsuransi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:revertPembayaranAsuransi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'revertPembayaranAsuransi';

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
		$pembayaran_ids        = [899, 900, 901, 902, 903, 904, 905];
		$pembayaran_asuransis  = PembayaranAsuransi::where('id', $pembayaran_ids)->get();
		$asuransi_id           = $pembayaran_asuransis->first()->asuransi_id;
		$nota_jual_ids         = [];

		$mulais = [];
		$akhirs = [];
		foreach ($pembayaran_asuransis as $pa) {
			$nota_jual_ids[] = $pa->nota_jual_id;
			$mulais[]        = $pa->mulai;
			$akhirs[]        = $pa->akhir;
		}
		JurnalUmum::where('jurnalable_type', 'App\\Models\\NotaJual')->whereIn('jurnalable_id', $nota_jual_ids )->delete();
		NotaJual::destroy($nota_jual_ids);
		PembayaranAsuransi::destroy($pembayaran_ids);
		PiutangDibayar::whereIn('pembayaran_asuransi_id', $pembayaran_ids)->delete();

		$query                 = "UPDATE periksas as px ";
		$query                .= "SET sudah_dibayar = 0 ";
		$query                .= "WHERE px.tanggal like '2020-02%' ";
		$query                .= "OR px.tanggal like '2019-12%' ";
		$query                .= "OR px.tanggal like '2019-08%' ";
		$query                .= "AND px.asuransi_id  = '{$asuransi_id}';";
		DB::statement($query);

		$ids_string = '';
		foreach ($pembayaran_ids as $k => $id) {
			if ($k) {
				$ids_string .= ',' . $id;
			} else {
				$ids_string .=  $id;
			}
		}
		DB::statement("UPDATE invoices set pembayaran_asuransi_id = null where pembayaran_asuransi_id in (".$ids_string.")");
		DB::statement("UPDATE rekenings set pembayaran_asuransi_id = null where pembayaran_asuransi_id in (".$ids_string.")");
    }
}
