<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Periksa;
use App\Models\Classes\Yoga;
use App\Models\Sms;
use Log;
use DB;


class smsLaporanHarian extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:laporanharian';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Laporan jumlah pasien harian yang dikirim lewat SMS';

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

		Log::info('smsLaporanHarian');
		Log::info('Saat ini ' . date('Y-m-d H:i:s'));
		Log::info('Seharusnya muncul tiap hari jam 23:00');

		$periksas = Periksa::where('tanggal',date('Y-m-d'))->get();

		$jumlahPasienTotal = $periksas->count();
        $hari_ini = date('Y-m-d');
        $query  = "SELECT count(id)  as jumlah ";
        $query .= "FROM periksas as prx ";
        $query .= "JOIN asuransis as asu on asu.id = prx.asuransi_id ";
        $query .= "WHERE prx.tanggal = '{$hari_ini}' ";
        $query .= "AND asu.tipe_asuransi_id = 5 ";
        $tenant_id = is_null( session()->get('tenant_id') ) ? 1 : session()->get('tenant_id');
        $query .= "AND prx.tenant_id = " . $tenant_id . ";";
        $jumlahPasienBPJS = DB::select($query)->first()->jumlah ;
		$tunai            = 0;
		$piutang          = 0;
		$estetika         = 0;
		foreach ($periksas as $v) {
			$tunai += $v->tunai;
			$piutang += $v->piutang;
			if ($v->poli->poli == 'estetika') {
				$estetika++;
			}
		}	
		$pesan = 'Jumlah pasien saat ini ' . $jumlahPasienTotal . ' pasien, pasien BPJS sebanyak ' . $jumlahPasienBPJS . ' pasien, pendapatan tunai ' . Yoga::buatrp($tunai) . ' piutang ' . Yoga::buatrp($piutang) . '.pasien estetika ' . $estetika . ' pasien';

		Sms::send(env('NO_HP_OWNER'), $pesan);
		Sms::send(env('NO_HP_OWNER2'), $pesan);
    }
}
