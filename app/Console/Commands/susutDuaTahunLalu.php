<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JurnalUmum;
use App\Models\Penyusutan;
use App\Models\RingkasanPenyusutan;

class susutDuaTahunLalu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:susutDuaTahunLalu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Penyusutan dua tahun lalu ';

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
    public function handle(){
		$penyusutans = Penyusutan::all();
		$last_ringkasan_penyusutan_id = RingkasanPenyusutan::orderBy('id', 'desc')->first()->id;
		$susuts = [];
		foreach ($penyusutans as $p) {
			$last_ringkasan_penyusutan_id++;
			$susuts[] = [
				'created_at'              => date('Y-m-d H:i:s', strtotime("-1 year " . $p->created_at )),
				'updated_at'              => date('Y-m-d H:i:s', strtotime("-1 year " . $p->updated_at )),
							'tenant_id'  => session()->get('tenant_id'),
				'keterangan'              => $p->keterangan,
				'susutable_id'            => $p->susutable_id,
				'susutable_type'          => $p->susutable_type,
				'nilai'                   => $p->nilai,
				'ringkasan_penyusutan_id' => 123123
			];
		}
		Penyusutan::insert($susuts);
    }
}
