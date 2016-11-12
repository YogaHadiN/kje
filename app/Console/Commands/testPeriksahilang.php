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
            $valid = false;
            foreach ($arrs as $key => $ar) {
                if ( $key > 0 && $arrs[$key-1]->coa_id == 110000 && $arrs[$key-1]->debit == 1 ){
                    $valid = true;
                }
                if ($valid && $ar->debit == 0) {
                    $sama = false;
                    foreach ($table as $k=> $tab) {
                        if( $tab['coa_id'] == $ar->coa_id){
                            $table[$k]['nilai'] = $tab['nilai'] + $ar->nilai;
                            $table[$k]['jumlah'] = $tab['jumlah'] + 1;
                            $sama = true;
                            $id_sama = false;
                            foreach ($tab['jurnalable_id'] as $jurnl) {
                                if ($jurnl == $rc->jurnalable_id) {
                                    $id_sama = true;
                                }
                            }
                            if (!$id_sama) {
                                $table[$k]['jurnalable_id'][] = $rc->jurnalable_id;
                            }
                        }
                    }
                    if (!$sama) {
                        $table[] =[
                            'id' => $ar->id,
                            'coa_id' => $ar->coa_id,
                            'coa'    => $ar->coa->coa,
                            'nilai'  => $ar->nilai,
                            'jumlah' => 1,
                            'jurnalable_id' => [
                                 $rc->jurnalable_id
                            ]
                        ]; 
                    }
                } else if ($ar->debit == 1 && $ar->coa_id != 110000 ) {
                        break;
                }
            }
        }
		return dd( $errors );
    }
}
