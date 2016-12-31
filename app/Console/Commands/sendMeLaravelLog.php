<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
		exec('cp /var/www/kje/storage/logs/laravel.log /home/kje/Dropbox/backup11/log/laravel' . date('Y-m-d_H_i_s') . '.log');
		exec('cp -r /var/www/kje/public/img/belanja /home/kje/Dropbox/backup11/img/belanja' . date('Y-m-d_H_i_s'));
		exec('cp -r /var/www/kje/public/img/alat /home/kje/Dropbox/backup11/img/alat' . date('Y-m-d_H_i_s'));
		exec('cp -r /var/www/kje/public/img/serviceAc /home/kje/Dropbox/backup11/img/serviceAc' . date('Y-m-d_H_i_s'));
		exec('cp -r /var/www/kje/public/img/lain /home/kje/Dropbox/backup11/img/lain' . date('Y-m-d_H_i_s'));
    }
}
