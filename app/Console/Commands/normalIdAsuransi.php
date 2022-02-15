<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Models\Asuransi;

class normalIdAsuransi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:com';

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
		DB::statement('ALTER TABLE asuransis ADD id2 bigint;');
		DB::statement('ALTER TABLE asuransis MODIFY id INT NOT NULL;');
		DB::statement('ALTER TABLE asuransis DROP PRIMARY KEY;');
		$asuransis = Asuransi::orderBy('id', 'desc')->get();
		foreach ($asuransis as $k => $asu) {
			$asu->id2 = $asu->id/1000000;
			$asu->save();
			DB::statement("update antrian_polis set asuransi_id='{$asu->id2}' where asuransi_id='{$asu->id}';");
			DB::statement("update periksas set asuransi_id='{$asu->id2}' where asuransi_id='{$asu->id}';");
			DB::statement("update pics set asuransi_id='{$asu->id2}' where asuransi_id='{$asu->id}';");
			DB::statement("update pembayaran_asuransis set asuransi_id='{$asu->id2}' where asuransi_id='{$asu->id}';");
			DB::statement("update pasiens set asuransi_id='{$asu->id2}' where asuransi_id='{$asu->id}';");
			DB::statement("update sops set asuransi_id='{$asu->id2}' where asuransi_id='{$asu->id}';");
			DB::statement("update tarifs set asuransi_id='{$asu->id2}' where asuransi_id='{$asu->id}';");
			DB::statement("update antrian_periksas set asuransi_id='{$asu->id2}' where asuransi_id='{$asu->id}';");
			DB::statement("update discount_asuransis set asuransi_id='{$asu->id2}' where asuransi_id='{$asu->id}';");
			DB::statement("update emails set emailable_id='{$asu->id2}' where emailable_id='{$asu->id}' and emailable_type='App\\\Models\\\Asuransi';");
			DB::statement("update telpons set telponable_id='{$asu->id2}' where telponable_id='{$asu->id}' and telponable_type='App\\\Models\\\Asuransi';");
		}
		DB::statement('ALTER TABLE asuransis DROP id;');
		DB::statement('ALTER TABLE asuransis CHANGE `id2` `id` bigint not null auto_increment primary key;');
    }
}
