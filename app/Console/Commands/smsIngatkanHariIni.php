<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Sms;
use App\AntrianPoli;

class smsIngatkanHariIni extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:ingatkanHariIni';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ingatkan kalo hari ini ada jadwal periksa ke dokter gigi';

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
		AntrianPoli::where('poli', 'gigi')
					->where('tanggal', date('Y-m-d'))
					->get();
		$pesan			= 'Selamat Siang, kami dari Klinik Jati Elok ingin hari ini Bapak / Ibu ada janji konsultasi ke dokter gigi jam 17.00. Terima Kasih';

		$text = "Terkirim sms mengingatkan janji konsultasi hari ini ";
		foreach ($antrianpolis as $ap) {
			Sms::send($ap->pasien->no_telp,$pesan);
			$text .= $ap->pasien->nama . ', ';
			\Log::info('Terkirim sms mengingatkan janji konsultasi ke ' . $ap->pasien->nama);
		}
		Sms::send('081381912803',$pesan);
		Sms::send('081381912803',$text);
    }
}
