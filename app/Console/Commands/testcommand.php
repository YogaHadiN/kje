<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Outbox;
use App\Pengeluaran;
use App\FakturBelanja;
use App\Periksa;
use DB;

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

		$query  = "SELECT ";
		$query .= "SUM(case when debit = 1 then nilai else 0 end) as nilai_debit, ";
		$query .= "SUM(case when debit = 0 then nilai else 0 end) as nilai_kredit, ";
		$query .= "jurnalable_id, ";
		$query .= "jurnalable_type ";
		$query .= "FROM jurnal_umums ";
		$query .= "WHERE created_at like '2016-11%' ";
		$query .= "GROUP BY jurnalable_id, jurnalable_type";
		$data = DB::select($query);
		$errors = [];
		foreach ($data as $v) {
			if ($v->nilai_debit != $v->nilai_kredit) {
				$errors[] = $v;
			}
		}	
		return Periksa::find($v->jurnalable_id)->pasien->id;
		//return dd( $errors );
		//return dd( $data );


	}
}
