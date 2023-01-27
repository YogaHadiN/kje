<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\JenisKulit;
use App\Models\PeriodeKeluhanUtama;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        JenisKulit::create([
            'jenis_kulit' => 'normal'
        ]);
        JenisKulit::create([
            'jenis_kulit' => 'sensitif'
        ]);
        JenisKulit::create([
            'jenis_kulit' => 'kering'
        ]);
        JenisKulit::create([
            'jenis_kulit' => 'berminyak'
        ]);
        JenisKulit::create([
            'jenis_kulit' => 'tidak tahu'
        ]);
        PeriodeKeluhanUtama::create([
            'periode_keluhan_utama' => '< 1 minggu'
        ]);
        PeriodeKeluhanUtama::create([
            'periode_keluhan_utama' => '1 minggu - 1 bulan'
        ]);
        PeriodeKeluhanUtama::create([
            'periode_keluhan_utama' => '1 bulan - 3 bulan'
        ]);
        PeriodeKeluhanUtama::create([
            'periode_keluhan_utama' => '3 bulan - 1 tahun'
        ]);
        PeriodeKeluhanUtama::create([
            'periode_keluhan_utama' => '> 1 tahun'
        ]);
    }
}

