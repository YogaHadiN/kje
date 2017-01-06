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
		$query  = "SELECT * from tarifs ";
		$query .= "WHERE jenis_tarif_id not in(Select id from jenis_tarifs) ";
		$data = DB::select($query);
		return dd( $data );
	}
}
