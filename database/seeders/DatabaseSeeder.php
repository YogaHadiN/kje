<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Tenant;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Tenant::where('id', 2)->update([
            'nursestation_availability' => 0,
            'name' => 'Klinik Suradita',
            'address_line1' => 'Perumnas Bumi Serpong Suradita, Jl. Wijaya Kusuma Raya 10',
            'address_line2' => 'Suradita, Cisauk, Tangerang',
            'address_line3' => 'Banten, Telp 02175790824',
        ]);
        Tenant::where('id', 1)->update([
            'address_line1' => 'Perumnas Bumi Serpong Suradita, Jl. Wijaya Kusuma Raya 10',
            'address_line2' => 'Suradita, Cisauk, Tangerang',
            'address_line3' => 'Banten, Telp 02175790824',
        ]);

        $query  = "select TABLE_NAME from INFORMATION_SCHEMA.COLUMNS where COLUMN_NAME like 'merek_id' order by TABLE_NAME";
        $count = 0;
        foreach (DB::select($query) as $table) {
            $q ='update ' . $table->TABLE_NAME . ' set merek_id = 34 where merek_id in (622, 2226)';
            DB::statement($q);
            Merek::destroy([622,2226]);
        }

    }
}
