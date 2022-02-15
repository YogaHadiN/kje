<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Prolanis;
use App\Models\Sms;
use App\Models\Config;
use Log;

class smsUndanganprolanis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:undanganprolanis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'SMS untuk mengundang peserta prolanis dilakukan setiap bulan';

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


		Log::info('SMS untuk mengundang peserta prolanis dilakukan setiap bulan');
		$prolanis = Prolanis::all();
		$tanggal_prolanis = Config::where('config_variable', 'tanggal_prolanis')->first()->value;

		Sms::send(env("NO_HP_OWNER2"), 'Undangan Prolanis BPJS untuk tanggal ' . $tanggal_prolanis);
    }
}
