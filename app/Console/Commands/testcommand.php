<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Outbox;
use App\Pengeluaran;
use DB;

class testcommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:command';

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

		$ju = Pengeluaran::create([
			'created_at'     => '2016-12-20 10:08:39',
			'updated_at'     => '2016-12-20 10:08:39',
			'staf_id'        =>10,
			'nilai'          =>35000,
			'supplier_id'    =>5,
			'tanggal'        => '2016-12-20',
			'sumber_uang_id' => '110000',
			'faktur_image'   => 'faktur608.jpg'
		]);

		$peng       = Pengeluaran::find($ju->id);
		$peng->id   = 608;
		$peng->save();


	}
}
