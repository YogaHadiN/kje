<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DateTime;
use App\Models\AntrianPoli;
use App\Models\Sms;
use Log;

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
		Log::info('smsIngatkanJanji');
		Log::info('Saat ini ' . date('Y-m-d H:i:s'));
		Log::info('Seharusnya muncul tiap hari jam 13:00');

		$date			= new DateTime(date('Y-m-d'));
		$date->modify('+1 day');
		$ap				= new AntrianPoli;
		$antrianpolis	= $ap->besokKonsulGigi();

		$text = "Terkirim sms mengingatkan janji konsultasi ke ";
		foreach ($antrianpolis as $ap) {
			$pesan			= 'Selamat Siang,Kami dari ' .env("NAMA_KLINIK") .', mengingatkan besok tanggal ' . $date->format('d-m-Y') . ' pasien a/n ' . $ap->pasien->nama . ' ada janji konsultasi ke dokter gigi';
			Sms::send($ap->pasien->no_telp,$pesan);
			$text .= $ap->pasien->nama . ', ';
			\Log::info('Terkirim sms mengingatkan janji konsultasi ke ' . $ap->pasien->nama);
		}
		if (!isset($pesan)) {
			$pesan			= 'Tidak ada mengingatkan janji dokter gigi besok';
		}
		Sms::send(env('NO_HP_OWNER'),$pesan);
		Sms::send(env('NO_HP_OWNER'),$text);
    }
}
