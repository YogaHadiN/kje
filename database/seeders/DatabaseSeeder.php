<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Asuransi;
use App\Models\Staf;
use App\Models\CekListDikerjakan;
use App\Http\Controllers\BayarGajiController;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        foreach (CekListDikerjakan::all() as $cek) {
            if (!$cek->cekListRuangan) {
                $cek->delete();
            }
        }
    }
}

