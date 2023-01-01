<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Tenant;
use App\Models\KategoriCekList;
use App\Models\FrekuensiCek;
use App\Models\Coa;
use App\Models\Modal;
use App\Models\Limit;
use App\Models\JurnalUmum;
use App\Models\JenisTarif;
use App\Models\CekList;
use App\Models\RecoveryIndex;
use App\Models\WaktuHadir;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Modal::where('id', 798)->update([
            'modal' => 625347
        ]);
        JurnalUmum::where('jurnalable_id', 798)
            ->where('jurnalable_type', 'App\Models\Modal')
            ->update([
            'nilai' => 625347
        ]);
    }
}
