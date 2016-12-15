<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class testConsole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:console';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perintah untuk test console shell script';

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
		if (gethostname() == 'kje') {
			exec("mysqldump -u root -pYogaman89 jatielok | gzip > /home/kje/Dropbox/backup11/database_`date '+%m-%d-%Y_%H:%M:%S'`.sql.gz");
		} else {
			exec("mysqldump -u root -pYogaman89 jatielok | gzip > /home/dell/Documents/backup11/database_`date '+%m-%d-%Y_%H:%M:%S'`.sql.gz");
		}
    }
}
