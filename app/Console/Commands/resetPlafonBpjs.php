<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use DB;

class resetPlafonBpjs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:resetPlafonBpjs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset Plafon BPJS';

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
     * @return int
     */
    public function handle()
    {
        $query  = "UPDATE stafs set plafon_bpjs = 0";
        DB::update($query);
        Log::info("Reset Plafon BPJS");
    }
}
