<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Outbox;
use App\Pengeluaran;
use App\AntrianPoli;
use App\Pasien;
use App\Sms;
use App\AntrianPeriksa;
use App\FakturBelanja;
use App\JurnalUmum;
use App\Periksa;
use DB;
use Mail;
use Input;

class testcommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:command';

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

		 $countAntrianPoli = AntrianPoli::where('poli', 'gigi')
			 ->where('tanggal', date('Y-m-d'))
			 ->count();
		 $countAntrianPeriksa = AntrianPeriksa::where('poli', 'gigi')
			 ->where('tanggal', date('Y-m-d'))
			 ->count();
		return dd(( $countAntrianPoli + $countAntrianPeriksa ) > 0);
	}
}
