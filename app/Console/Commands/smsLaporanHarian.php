<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Periksa;
use App\Classes\Yoga;
use App\Sms;
use Log;


class smsLaporanHarian extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:laporanharian';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Laporan jumlah pasien harian yang dikirim lewat SMS';

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

		Log::info('smsLaporanHarian');
		Log::info('Saat ini ' . date('Y-m-d H:i:s'));
		Log::info('Seharusnya muncul tiap hari jam 23:00');

		$periksas = Periksa::where('tanggal',date('Y-m-d'))->get();

		$jumlahPasienTotal = $periksas->count();
		$jumlahPasienBPJS = Periksa::where('tanggal', 'like', date('Y-m-d'))
							->where('asuransi_id', '32')
							->count();
		$tunai = 0;
		$piutang = 0;
		foreach ($periksas as $v) {
			$tunai += $v->tunai;
			$piutang += $v->piutang;
		}	
		$pesan = 'Jumlah pasien saat ini ' . $jumlahPasienTotal . ' pasien, pasien BPJS sebanyak ' . $jumlahPasienBPJS . ' pasien, pendapatan tunai ' . Yoga::buatrp($tunai) . ' piutang ' . Yoga::buatrp($piutang);

		Sms::send('081381912803', $pesan);
		Sms::send('085721012351', $pesan);
    }
}
