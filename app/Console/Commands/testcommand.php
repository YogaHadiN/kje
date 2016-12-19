<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Outbox;
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
		$query  = "SELECT ge.generik, mr.id, mr.merek FROM mereks as mr ";
		$query .= "JOIN raks as rk on rk.id = mr.rak_id ";
		$query .= "JOIN formulas as fo on fo.id = rk.formula_id ";
		$query .= "JOIN komposisis as ko on ko.formula_id = fo.id ";
		$query .= "JOIN generiks as ge on ge.id = ko.generik_id ";
		$query .= "WHERE mr.id = 161117004;";
		$data = DB::select($query);

		$query  = "SELECT * from komposisis ";
		$query .= "WHERE generik_id = 1202 ";
		$data = DB::select($query);
		

		return dd( $data );
    }
}
