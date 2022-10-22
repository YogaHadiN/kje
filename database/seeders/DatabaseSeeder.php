<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Ruangan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Ruangan::create([
            'nama'                      => 'Ruang Periksa 3',
            'file_panggilan'            => 'ruang_periksa_tiga',
            'anafilactic_kit_available' => 1,
            'temperature_sensitive'     => 0,
        ]);
    }
}
