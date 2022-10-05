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
            'nama' => 'Loket 1',
            'file_panggilan' => 'loketsatu',
            'anafilactic_kit_available' => 0,
            'temperature_sensitive' => 0
        ]);

        Ruangan::create([
            'nama' => 'Loket 2',
            'file_panggilan' => 'loketdua',
            'anafilactic_kit_available' => 0,
            'temperature_sensitive' => 0
        ]);

        Ruangan::create([
            'nama' => 'Ruang Periksa 1',
            'file_panggilan' => 'ruangperiksasatu',
            'anafilactic_kit_available' => 1,
            'temperature_sensitive' => 0
        ]);
        Ruangan::create([
            'nama' => 'Ruang Periksa 2',
            'file_panggilan' => 'ruangperiksadua',
            'anafilactic_kit_available' => 1,
            'temperature_sensitive' => 0
        ]);
        Ruangan::create([
            'nama' => 'Ruang Periksa Gigi',
            'file_panggilan' => 'ruangperiksagigi',
            'anafilactic_kit_available' => 1,
            'temperature_sensitive' => 0
        ]);
        Ruangan::create([
            'nama' => 'Ruang Pemeriksaan Fisik',
            'file_panggilan' => 'ruangpf',
            'anafilactic_kit_available' => 0,
            'temperature_sensitive' => 0
        ]);

        Ruangan::create([
            'nama' => 'Ruang UGD',
            'file_panggilan' => null,
            'anafilactic_kit_available' => 1,
            'temperature_sensitive' => 0
        ]);

        Ruangan::create([
            'nama' => 'Ruang Farmasi',
            'file_panggilan' => 'farmasi',
            'anafilactic_kit_available' => 0,
            'temperature_sensitive' => 1
        ]);
        Ruangan::create([
            'nama' => 'Ruang Gudang Obat',
            'file_panggilan' => null,
            'anafilactic_kit_available' => 0,
            'temperature_sensitive' => 1
        ]);
    }
}
