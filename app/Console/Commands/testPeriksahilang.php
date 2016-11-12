<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\CheckoutKasir;
use DB;

class testPeriksahilang extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:periksahilang';

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

        $checkout = CheckoutKasir::latest()->first();
        $jurnal_umum_id = $checkout->jurnal_umum_id;
        $query = "select min(jurnalable_type) as jurnalable_type, min(ju.id) as id, jurnalable_id as jurnalable_id, min( coa_id ) as coa_id from jurnal_umums as ju where coa_id=110000 and debit = 1 and ju.id > {$jurnal_umum_id} group by jurnalable_id;";
        $rinci = DB::select($query);
        $table = [];

		$errors = [];

        foreach ($rinci as $rc) {
			try {
				$arrs = $rc->jurnalable_type::where('id', $rc->jurnalable_id)->first()->jurnals;
			} catch (\Exception $e) {
				$errors[] = $rc ;
			}
        }
		return dd( $errors );
    }
}
