<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Sms;
use App\AntrianPoli;
use App\Pasien;
use App\AntrianPeriksa;
use Log;

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
		Log::info('smsIngatkanHariIni');
		Log::info('Saat ini ' . date('Y-m-d H:i:s'));
		Log::info('Seharusnya muncul tiap hari jam 12:30');
		$antrianpolis = AntrianPoli::where('poli', 'gigi')
					->where('tanggal', date('Y-m-d'))
					->get();
		$antrianperiksas = AntrianPeriksa::where('poli', 'gigi')
					->where('tanggal', date('Y-m-d'))
					->get();
		$pasiens = [];
		foreach ($antrianpolis as $ap) {
			$pasiens[] = $ap->pasien_id;
		}

		foreach ($antrianperiksas as $ap) {
			$pasiens[] = $ap->pasien_id;
		}

		$pasiens = array_unique( $pasiens );

		$ps = Pasien::whereIn('id', $pasiens)->get();
		$text = "Terkirim sms mengingatkan janji konsultasi HARI INI ke " . count($ps) . ' orang : ';
		foreach ($ps as $ap) {
			$pesan			= 'Selamat Siang, kami dari Klinik Jati Elok mengingatkan pasien a/n ' . $ap->nama . ' ada janji konsultasi ke dokter gigi hari ini jam 17.00.';
			Sms::send($ap->no_telp,$pesan);
			$text .= $ap->nama . ', ';
			\Log::info('Terkirim sms mengingatkan janji konsultasi HARI INI ke ' . $ap->nama);
		}
		Sms::send('081381912803',$pesan);
		Sms::send('081381912803',$text);
    }
}
