<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Outbox;
use App\Pengeluaran;
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
		$ju = JurnalUmum::whereRaw('coa_id between 400051 and 400148')->get();
		$jurnals = [];
		$errors = [];
		foreach ($ju as $j) {
			$jurnals[] = [
				'jurnalable_id' =>$j->jurnalable_id,
				'jurnalable_type' => $j->jurnalable_type
			];
		}
		$count = 0;
		foreach ($jurnals as $ju) {
			$confirm = JurnalUmum::where('jurnalable_id', $ju['jurnalable_id'])
						->where('jurnalable_type', $ju['jurnalable_type'])
						->delete();
			$count = (int) $count + (int) $confirm;
		}
		return dd( $count );
	}
}
