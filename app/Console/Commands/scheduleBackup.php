<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;

class scheduleBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:scheduleBackup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perintah untuk backup database jatielok';

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
		Log::info('dibackup ' . date('Y-m-d H:i:s'));
        if (gethostname() == 'MacBook-Pro-2.local') {
            exec('mysqldump --user=root --password=Yogaman89 jatielok | gzip > ~/Sites/database/jatielok_`date +"%Y-%m-%d_%H:%M:%S"`.sql.gz');
        } else {
            exec('mysqldump --user=root --password=Yogaman89 jatielok | gzip > /var/database/jatielok_`date +"%Y-%m-%d_%H:%M:%S"`.sql.gz');
        }
    }
}
