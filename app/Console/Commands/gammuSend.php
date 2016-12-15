<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class gammuSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gammu:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test kirim sms menggunakan Gammu';

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

    }
}
