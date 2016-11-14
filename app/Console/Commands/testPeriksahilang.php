<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\CheckoutKasir;
use DB;
use App\Sms;

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
				$errors[] = $rc->jurnalable_id ;
			}
        }
		if ( count( $errors ) ) {
			$pesan = "Ada " . count($errors) . " yang hilang, yaitu ";
			foreach ($errors as $error) {
				$pesan .= $error . ', ';
			}
			Sms::send('081381912803', $pesan);
		} else{
			Sms::send('081381912803', 'Tidak ada pemeriksaan yang hilang');
		} 

		
    }
}
