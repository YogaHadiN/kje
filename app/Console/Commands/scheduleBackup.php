<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
		exec('mysqldump --user=root --password=Yogaman89 jatielok | gzip > /home/kje/Dropbox/backup11/jatielok_`date +"%Y-%m-%d_%H:%M:%S"`.sql.gz');
    }
}
