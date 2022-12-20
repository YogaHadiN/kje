<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;
use Log;
use App\Models\Antrian;
use App\Models\WhatsappRecoveryIndex;
use App\Http\Controllers\WablasController;

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
    protected $description = 'Follow up pengobatan pasien 2 hari yang lalu';

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
        $dua_hari_yl                 = Carbon::now()->subDays(2);
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
        $query .= "psn.tanggal_lahir as tanggal_lahir, ";
        $query .= "ant.no_telp as no_telp, ";
        $query .= "ant.id as antrian_id ";
        $query .= "FROM periksas as prx ";
        $query .= "JOIN antrians as ant on ant.antriable_id = prx.id and antriable_type = 'App\\\Models\\\Periksa' ";
        $query .= "JOIN pasiens as psn on psn.id = prx.pasien_id ";
        $query .= "JOIN diagnosas as dgn on dgn.id = prx.diagnosa_id  ";
        $query .= "JOIN icd10s as icd on icd.id = dgn.icd10_id  ";
        $query .= "LEFT JOIN rujukans as rjk on rjk.periksa_id = prx.id  ";
        $query .= "WHERE ant.created_at like '{$dua_hari_yl->format('Y-m-d')}%' ";
        if ( count($antrian_now_and_yesterday) ) {
            $query .= "AND prx.pasien_id not in (" . $pasien_id_ekslusi . ") ";
        }
        $query .= "AND ant.jenis_antrian_id = 1 "; // pasien dari poli umum
        $query .= "AND dgn.icd10_id not like 'Z3%' "; // bukan periksa hamil dan suntik kb
        $query .= "AND dgn.icd10_id not like 'Z0%' "; // bukan diagnosa sks
        $query .= "AND dgn.icd10_id not like 'A5%' "; // bukan diagnosa penyakit menural seksual
        $query .= "AND dgn.icd10_id not like 'Z1%' "; // bukan diagnosa pemeriksan rapid test
        $query .= "AND rjk.id is null "; // bukan pasien dirujuk
        $query .= "AND ant.no_telp is not null "; // nomot telepon di antrian tidak dikosongkan
        $query .= "AND ant.tenant_id = 1 "; // bukan pasien dirujuk
        $result = DB::select($query);

        $data       = [];
        $wa_indices = [];
        $timestamp  = date('Y-m-d H:i:s');
        foreach ($result as $k => $d) {
            $message = 'Selamat Siang. Maaf mengganggu. Izin menanyakan kabar pasien atas nama ';
            $message .= PHP_EOL;
            $message .= PHP_EOL;
            $message .= ucwords($d->nama);
            $message .= PHP_EOL;
            $message .= PHP_EOL;
            $message .=' setelah berobat tanggal ' . $dua_hari_yl->format('d M Y'). '. Bagaimana kabarnya setelah pengobatan kemarin?';
            $message .= PHP_EOL;
            $message .='1. Sudah Sembuh';
            $message .= PHP_EOL;
            $message .='2. Membaik';
            $message .= PHP_EOL;
            $message .='3. Tidak ada perubahan';
            $message .= PHP_EOL;
            $message .= PHP_EOL;
            $message .='Mohon balas dengan angka *1,2 atau 3* sesuai dengan informasi di atas';

            Log::info("terkirim followuppengobatan ke pasien atas nama " . ucwords($d->nama));

            $wa_indices[] = [
                'antrian_id' => $d->antrian_id,
                'no_telp'    => $d->no_telp,
                'created_at' => $timestamp,
                'updated_at' => $timestamp
            ];

            $data[] = [
                'phone'   => $d->no_telp,
                'message' => $message
            ];
        }
        WhatsappRecoveryIndex::insert($wa_indices);

        $wablas = new WablasController;
        $wablas->bulkSend($data);
    }
}
