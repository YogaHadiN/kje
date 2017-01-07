<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Discount;
use Carbon\Carbon;
use Log;

class dbHapusdiskon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:hapusDiskon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hapus Diskon yang sudah berakhir';

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
		Log::info('dbHapusdiskon');
		Log::info('Saat ini ' . date('Y-m-d H:i:s'));
		Log::info('Seharusnya muncul tiap hari jam 23:50');
		Discount::where('berakhir', '<', Carbon::now())->delete();
    }
}
