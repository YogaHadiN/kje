<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;

class SyncImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:image';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync gambar ke dropbox tiap menit';

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
        Log::info('===============================');
        Log::info(date('Y-m-d H:i:s'));
        Log::info('===============================');
    }
}
