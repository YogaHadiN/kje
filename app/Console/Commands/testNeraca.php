<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use DateTime;
use App\Models\Sms;
use App\Models\Classes\Yoga;
use Log;

class testNeraca extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:neraca';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cek Hari Ini apakah ada neraca yang tidak seimbang';

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
		Log::info('testNeraca');
		Log::info('Saat ini ' . date('Y-m-d H:i:s'));
		Log::info('Seharusnya muncul tiap hari jam 01:00');

		$date			= new DateTime(date('Y-m-d'));
		$date->modify('-1 day');
		$query  = "SELECT sum(nilai) as nilai FROM jurnal_umums ";
		$query .= "WHERE created_at like '" .$date->format('Y-m-d'). "' ";
		$query .= "AND tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "AND debit = 1 ";
		$data = DB::select($query);
		$debit = 0;
		foreach ($data as $d) {
			$debit += $d->nilai;
		}
		$query  = "SELECT sum(nilai) as nilai FROM jurnal_umums ";
		$query .= "WHERE created_at like '" .$date->format('Y-m-d'). "' ";
		$query .= "AND tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "AND debit = 0 ";
		$data = DB::select($query);
		$kredit = 0;
		foreach ($data as $d) {
			$kredit += $d->nilai;
		}

		if ( $debit == $kredit ) {
			Sms::send(env('NO_HP_OWNER'), 'Neraca Seimbang');
		} else {
			Sms::send(env('NO_HP_OWNER'), 'Neraca TIDAK Seimbang debit = ' . Yoga::buatrp($debit) . ' kredit = ' . Yoga::buatrp($kredit));
		}
		
    }
}
