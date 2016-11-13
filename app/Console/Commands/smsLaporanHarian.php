<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Periksa;
use App\Sms;


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
		$periksa = new Periksa;
		$poliIni = $periksa->poliIni(date('Y-m-d'), '%%');
		$polis = $poliIni['polis'];
		$periksas = $poliIni['periksas'];
		$pesan = 'Jumlah pasien saat ini ' . count($periksas) . ' pasien';
		Sms::send('081381912803', $pesan);
    }
}
