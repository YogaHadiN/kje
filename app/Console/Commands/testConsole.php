<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Dispensing;
use App\Models\Classes\Yoga;
use App\Models\Pasien;
use App\Models\Periksa;
use App\Models\PembayaranAsuransi;
use App\Models\NotaJual;
use App\Models\JurnalUmum;
use App\Models\PiutangDibayar;
use App\Models\TransaksiPeriksa;
use Log;
use DB;
use App\Events\updateMonitor;
use App\Http\Controllers\CustomController;

class testConsole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:console';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perintah untuk test console shell script';

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
		$pembayaran_ids        = [863, 823, 822, 799, 767, 755, 753, 752, 751, 750, 737, 716, 715, 714, 713, 712, 695, 691, 683];
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
		NotaJual::destroy($nota_jual_ids);
		PembayaranAsuransi::destroy($pembayaran_ids);
		JurnalUmum::where('jurnalable_type', 'App\\Models\\NotaJual')->whereIn('jurnalable_id', $nota_jual_ids )->delete();
		PiutangDibayar::whereIn('pembayaran_asuransi_id', $pembayaran_ids)->delete();

		$query                 = "UPDATE periksas as pa ";
		$query                .= "SET sudah_dibayar = 0 ";
		$query                .= "WHERE px.tanggal like '2019%' ";
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
		DB::statement("UPDATE asuransis set kali_obat = 1.25 where kali_obat is null");
    }
}
