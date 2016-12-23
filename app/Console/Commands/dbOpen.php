<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class dbOpen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:open';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Open database';

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
			exec("mysql -u root -pYogaman89 jatielok");
    }
}
