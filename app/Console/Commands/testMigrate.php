<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AntrianPoli;
use App\Models\AntrianPeriksa;

class testMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
		$antrianperiksas = AntrianPeriksa::whereIn('poli', [
								'umum',
								'sks',
								'luka'
							])->get();

		$antrianpolis = AntrianPoli::whereIn('poli', [
								'umum',
								'sks',
								'luka'
							])->get();

		$antrians = [];

		foreach ($antrianperiksas as $aperiksa) {
			$antrians[] = $aperiksa->antrian;
		}
		foreach ($antrianpolis as $apoli) {
			$antrians[] = $apoli->antrian;
		}

		dd($antrians);

    }
}
