<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Tenant;
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


        RecoveryIndex::create([
            'recovery_index' => 'Memburuk'
        ]);
        RecoveryIndex::create([
            'recovery_index' => 'Tidak ada perubahan'
        ]);
        RecoveryIndex::create([
            'recovery_index' => 'Membaik'
        ]);
        /* Tenant::where('id', 1)->update([ */
        /*     'address' => 'Komp. Bumi Jati Elok Blok A I No. 7, Jl. Raya Legok - Parung Panjang km. 3, Malangnengah, Pagedangan, Tangerang, Bante.', */
        /*     'address_line1' => 'Komplek Bumi Jati Elok Blok A I No. 7', */
        /*     'no_telp' => '0215977529', */
        /*     'address_line2' => 'Jl. Raya Legok - Parung Panjang km. 3', */
        /*     'address_line3' => 'Malangnengah, Pagedangan, Tangerang, Banten Telp 021 5977529', */
        /* ]); */
        /* Tenant::where('id', 2)->update([ */
        /*     'address' => 'Perumnas Bumi Serpong Suradita, Jl. Wijaya Kusuma Raya 10, Suradita, Cisauk, Tangerang, Banten, Telp 02175790824', */
        /*     'no_telp' => '02175790824', */
        /* ]); */
    }
}
