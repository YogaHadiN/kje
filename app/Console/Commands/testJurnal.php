<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Sms;

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
		$query  = "SELECT id from periksas where id not in(select jurnalable_id from jurnal_umums where jurnalable_type='App\\\Periksa') and created_at like '" . date('Y-m-d'). "%';";
		$data = DB::select($query);
		$text = 'Periksa yang tidak masuk jurnal ';
		if (count( $data )) {

			foreach ($data as $d) {
				$text .= $d . ', ';
			}
			
		} else {
			$text .= 'tidak ada' ;
		}

		Sms::send('081381912803', $text);
    }
}
