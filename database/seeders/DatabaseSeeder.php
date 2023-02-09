<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Asuransi;
use App\Models\Staf;
use App\Http\Controllers\BayarGajiController;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Asuransi::whereIn('id', [187,210] )->update([
            'konfirmasi_obat_paten' => 0
        ]);
    }
}

