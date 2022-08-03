<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DateTime;
use App\Models\Ac;
use App\Models\ServiceAc;
use App\Models\Sms;
use DB;
use Log;

class smsPanggilTukanAc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:panggilTukangAc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Panggil Tukang Ac jika ada ac yang udah 90 hari gak di service';

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

		Log::info('smsPanggilTukanAc');
		Log::info('Saat ini ' . date('Y-m-d H:i:s'));
		Log::info('Seharusnya muncul tiap hari jam 13:30');

		$date			= new DateTime(date('Y-m-d'));
		$date->modify('-90 day');
		$query  = "SELECT max(tanggal) as tanggal, ";
		$query .= "ac_id ";
		$query .= "FROM service_acs ";
		$query .= "WHERE tenant_id = 1 ";
		/* $query .= "WHERE tenant_id = " . session()->get('tenant_id') . " "; */
		$query .= "GROUP BY ac_id ";
		$query .= "ORDER BY tanggal desc ";
		$data   = DB::select($query);
		$ids = [];
		foreach ($data as $d) {
			if ($d->tanggal < $date->format('Y-m-d')) {
				$ids[] = $d->ac_id;
			}
		}
		$acs = Ac::all();
		foreach ($acs as $ac) {
			if ($ac->serviceAc->count() == 0 && $ac->created_at < $date->format('Y-m-d H:i:s')) {
				$ids[] = $ac->id;
			}
		}
		$ids = array_unique($ids);

		$pesan = "Mas tolong datang ke " . env("NAMA_KLINIK") ." besok ada yang mau diservis, jangan lupa bawa freon ";
		foreach (Ac::whereIn('id', $ids)->get() as $v) {
			$pesan .= $v->keterangan . ', ';
		}
		Sms::send(env('NO_HP_OWNER'), $pesan);
    }
}
