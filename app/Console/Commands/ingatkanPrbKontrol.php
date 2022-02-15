<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Http\Controllers\PasiensController;
use App\Models\Sms;

class ingatkanPrbKontrol extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prb:kontrol';

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
		$p                            = new PasiensController;
		$pasien_ids                   = $p->pasienRujukBalikIds();
		$pasiens                      = Pasien::whereIn('id', $pasien_ids)->get();
		$periksa_bulan_ini_pasien_ids = $p->prbPeriksaBulanIniPasienIds($pasien_ids);

		foreach ($pasiens as $pasien) {
			if ( !in_array($pasien->id, $periksa_bulan_ini_pasien_ids) ) {
				$this->sendWa($pasien);
			}
		}
    }
	private function sendWa($pasien){
		$message = "Selamat Sore. Maaf mengganggu. Kami dari Klinik Jati Elok izin mengingatkan pasien atas nama " . $pasien->nama . " untuk memeriksakan diri di Klinik untuk mengambil resep bulanan obat PRB BPJS. Terima kasih";
		Sms::send($pasien->no_telp, $message);
		Log::info('Terkirim wa ke ' . $pasien->no_telp . ' : ' . $message);
	}
}
