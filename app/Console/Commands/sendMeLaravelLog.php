<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;

class sendMeLaravelLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:melaravelLog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim Laravel.Log setiap hari jam 1 pagi ke dropbox';

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
		Log::info('sendMeLaravelLog');
		Log::info('Saat ini ' . date('Y-m-d H:i:s'));
		Log::info('Seharusnya muncul tiap hari jam 01:00');
		$this->sendLog();
		exec('rsync -avh --dry-run /var/www/kje/public/img/ ~/Dropbox/backup11/img/');
    }

	public function sendLog(){
		exec('cp /var/www/kje/storage/logs/laravel.log ~/Dropbox/backup11/log/laravel' . date('Y-m-d_H_i_s') . '.log');
		//exec('cp /var/www/kje/storage/logs/laravel.log /home/kje/Documents/laravel' . date('Y-m-d_H_i_s') . '.log');
	}
}
