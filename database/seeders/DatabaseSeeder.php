<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Tenant;
use App\Models\KategoriCekList;
use App\Models\FrekuensiCek;
use App\Models\Coa;
use App\Models\Limit;
use App\Models\JurnalUmum;
use App\Models\JenisTarif;
use App\Models\CekList;
use App\Models\RecoveryIndex;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $tenant = Tenant::find(2);
        $tenant->exp_date_validation_available = 0;
        $tenant->save();
    }
}
