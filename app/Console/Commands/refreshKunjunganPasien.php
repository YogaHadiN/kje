<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use DB;

class refreshKunjunganPasien extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:refreshKunjunganPasien';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Merefresh kunjungan menjadi belum berobat bulan ini';

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
		Log::info('Kunjungan refreshed');
		Log::info('Verifikasi prolanis refreshed');
		DB::statement('Update pasiens set sudah_kontak_bulan_ini = 0;');
		DB::statement('Update pasiens set verifikasi_prolanis_dm_id = 1;'); //verifikasi_prolanis 1 = "belum"
		DB::statement('Update pasiens set verifikasi_prolanis_ht_id = 1;'); //verifikasi_prolanis 1 = "belum"
    }
}
