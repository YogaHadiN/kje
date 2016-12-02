<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DateTime;
use App\AntrianPoli;
use App\Sms;

class smsIngatkanJanji extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:ingatkanJanji';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengingatkan kepada pasien yang mau ke dokter gigi';

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
		$date			= new DateTime(date('Y-m-d'));
		$date->modify('+1 day');
		$ap				= new AntrianPoli;
		$antrianpolis	= $ap->besokKonsulGigi();
		$pesan			= 'Selamat Siang, kami dari Klinik Jati Elok ingin mengingatkan besok tanggal ' . $date->format('d-m-Y') . ' Bapak / Ibu ada janji konsultasi ke dokter gigi. Terima Kasih';

		foreach ($antrianpolis as $ap) {
			Sms::send($ap->pasien->no_telp,$pesan);
			\Log::info('Terkirim sms mengingatkan janji konsultasi ke ' . $ap->pasien->nama);
		}
    }
}
