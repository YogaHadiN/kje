<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Merek;

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
		$mereks = Merek::all();
		$errors = [];
		foreach ($mereks as $m) {
			try {
				$f = $m->rak->formula;
			} catch (\Exception $e) {
				$errors[] = $m;
			}
			
		}
		return dd( $errors );
    }
}
