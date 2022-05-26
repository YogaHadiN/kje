<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use DB;

class refrestAntrianTiapHari extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:antrian';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh Antrian setiap hari';

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
        Log::info('Refresh Antrian Tiap Hari');
        DB::statement('update jenis_antrians set antrian_terakhir_id = null;');
    }
}
