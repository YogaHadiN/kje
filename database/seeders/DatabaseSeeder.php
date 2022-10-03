<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Titel;
use App\Models\Staf;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $tidak_ada_titel = Titel::create([
            'titel' => 'Tidak ada titel',
            'singkatan' => ''
        ]);
        $dokter = Titel::create([
            'titel' => 'Dokter',
            'singkatan' => 'Dr'
        ]);
        $doktergigi = Titel::create([
            'titel' => 'Dokter Gigi',
            'singkatan' => 'Drg'
        ]);
        $bidan = Titel::create([
            'titel' => 'Bidan',
            'singkatan' => 'Bd'
        ]);
        $perawat = Titel::create([
            'titel' => 'Perawat',
            'singkatan' => 'Ns'
        ]);
        $apoteker = Titel::create([
            'titel' => 'Apoteker',
            'singkatan' => 'Apt'
        ]);


        Staf::where('titel_id', 'dr')->update([
            'titel_id' => $dokter->id
        ]);
        Staf::where('titel_id', 'drg')->update([
            'titel_id' => $doktergigi->id
        ]);
        Staf::where('titel_id', 'bd')->update([
            'titel_id' => $bidan->id
        ]);
        Staf::where('titel_id', 'ns')->update([
            'titel_id' => $perawat->id
        ]);
        Staf::where('titel_id', 'apt')->update([
            'titel_id' => $apoteker->id
        ]);
    }
}
