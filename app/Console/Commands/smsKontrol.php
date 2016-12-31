<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DateTime;
use App\Kontrol;
use App\Sms;

class smsKontrol extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:kontrol';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ingatkan Pasien yang akan kontrol 1 hari sebelumnya';

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
		$ko       = new Kontrol;
		$kontrols = $ko->besokKontrol();
		$date     = new DateTime(date('Y-m-d'));
		$date->modify('+1 day');

		$text = 'Terkirim sms mengingatkan janji konsultasi ke ';
		foreach ($kontrols as $ap) {
			$pesan			= 'kami dari Klinik Jati Elok ingin mengingatkan besok tanggal ' . $date->format('d-m-Y') . ' pasien a/n ' . $ap->periksa->pasien->nama. ' kami sarankan Bapak / Ibu untuk konsultasi kembali ke dokter. Terima Kasih';
			Sms::send($ap->periksa->pasien->no_telp,$pesan);
			\Log::info('Terkirim sms mengingatkan janji konsultasi ke ' . $ap->pasien->nama);
			$text .= $ap->periksa->pasien->nama . ', ';
		}


		Sms::send('081381912803',$text);
    }
}
