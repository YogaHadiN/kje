<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\Sms;
use Log;

class testJurnal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:jurnal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test apakah ada Periksa yang tidak ada di Jurnal Umum';

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
		Log::info('testJurnal');
		Log::info('Saat ini ' . date('Y-m-d H:i:s'));
		Log::info('Seharusnya muncul tiap hari jam 23:30');
		$query  = "SELECT id from periksas ";
		$query .= "where id not in(select jurnalable_id from jurnal_umums where jurnalable_type='App\\\Models\\\Periksa')  ";
		$query .= "AND tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and created_at like '" . date('Y-m-d'). "%' ";
		$data   = DB::select($query);
		$text = 'Periksa yang tidak masuk jurnal ';
		if (count( $data )) {
			foreach ($data as $d) {
				$text .= $d->id . ', ';
			}
		} else {
			$text .= 'tidak ada' ;
		}
		$query  = "SELECT id ";
		$query .= "from jurnal_umums ";
		$query .= "where jurnalable_type='App\\\Models\\\Periksa' ";
		$query .= "AND tenant_id = " . session()->get('tenant_id') . " ";
		$query .= "and created_at like '" . date('Y-m-d') . "%' ";
		$query .= "and jurnalable_id not in (select id from periksas where created_at like '". date('Y-m-d') . "%') ";
		$data = DB::select($query);
		$text .= '. Jurnal yang tidak masuk periksa ';
		if (count($data)) {
			foreach ($data as $d) {
				$text .= $d->id . ', ';
			}
		} else {
			$text .= 'tidak ada' ;
		}
		Sms::send(env("NO_HP_OWNER"), $text);
    }
}
