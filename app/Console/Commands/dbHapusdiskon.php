<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Discount;
use Carbon\Carbon;

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
		Discount::where('berakhir', '<', Carbon::now())->delete();
    }
}
