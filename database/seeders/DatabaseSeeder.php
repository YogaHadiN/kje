<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Tenant;
use App\Models\Coa;
use App\Models\JurnalUmum;
use App\Models\JenisTarif;
use App\Models\RecoveryIndex;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        RecoveryIndex::truncate();

        RecoveryIndex::create([
            'recovery_index' => 'Tidak ada perubahan'
        ]);
        RecoveryIndex::create([
            'recovery_index' => 'Keluhan Membaik'
        ]);
        RecoveryIndex::create([
            'recovery_index' => 'Sudah Sembuh'
        ]);

    }
}
