<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Antrian;

class resetAntrian extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:antrian';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset Antrian ke Semula';

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
		$An						= Antrian::find(1);
		$An->antrian_terakhir   = 0;
		$An->save();
    }
}
