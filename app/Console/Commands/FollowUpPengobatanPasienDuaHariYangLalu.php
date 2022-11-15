<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;
use App\Models\Antrian;

class FollowUpPengobatanPasienDuaHariYangLalu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:followuppengobatan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Foloow up pengobatan pasien 2 hari yang lalu';

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
     * @return int
     */
    public function handle()
    {
        // ambil pasien 2 hari yang lalu
        // ekskluasikan bila pasien ada pengobatan hari ini dan kemarin
        //
        $dua_hari_yl                 = Carbon::now()->subDays(2)->format('Y-m-d');
        $kemarin                     = Carbon::now()->subDay()->format('Y-m-d');
        $hari_ini_sampai_nanti_malam = Carbon::now()->format('Y-m-d 23:59:59');

        $antrian_now_and_yesterday = Antrian::with('antriable')
                                            ->whereRaw("created_at between '" . $kemarin . "' and '"  . $hari_ini_sampai_nanti_malam . "'")
                                            ->where('antriable_type', 'App\Models\Periksa' )
                                            ->get();


        $pasien_id_ekslusi = '';

        foreach ($antrian_now_and_yesterday as $k => $ant) {
            $pasien_id_ekslusi .= $k == 0? $ant->antriable->pasien_id : ',' . $ant->antriable->pasien_id;
        }

        $query  = "SELECT ";
        $query .= "psn.nama as nama, ";
        $query .= "ant.no_telp as no_telp ";
        $query .= "FROM periksas as prx ";
        $query .= "JOIN antrians as ant on ant.antriable_id = prx.id and antriable_type = 'App\\\Models\\\Periksa' ";
        $query .= "JOIN pasiens as psn on psn.id = prx.pasien_id ";
        $query .= "JOIN diagnosas as dgn on dgn.id = prx.diagnosa_id  ";
        $query .= "JOIN icd10s as icd on icd.id = dgn.icd10_id  ";
        $query .= "LEFT JOIN rujukans as rjk on rjk.periksa_id = prx.id  ";
        $query .= "WHERE ant.created_at like '{$dua_hari_yl}%' ";
        $query .= "AND prx.pasien_id not in (" . $pasien_id_ekslusi . ") ";
        $query .= "AND ant.jenis_antrian_id = 1 "; // pasien dari poli umum
        $query .= "AND dgn.icd10_id not like 'Z3%' "; // bukan periksa hamil dan suntik kb
        $query .= "AND dgn.icd10_id not like 'Z0%' "; // bukan diagnosa sks
        $query .= "AND dgn.icd10_id not like 'A5%' "; // bukan diagnosa penyakit menural seksual
        $query .= "AND dgn.icd10_id not like 'Z1%' "; // bukan diagnosa pemeriksan rapid test
        $query .= "AND rjk.id is null "; // bukan pasien dirujuk
        $query .= "AND ant.no_telp is not null "; // bukan pasien dirujuk
        $query .= "AND ant.tenant_id = 1 "; // bukan pasien dirujuk
        $data = DB::select($query);


        $credentials = [];
        foreach ($data as $d) {
            $credentials[] = [
                'nama' => $d->nama,
                'no_telp' => $d->no_telp,
            ];
        }

        dd( $credentials );



    }
}
