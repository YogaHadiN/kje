<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Ruangan;
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
        DB::statement("update documents set tenant_id = 1;");
        DB::statement("update stafs set aktif = 0 where tenant_id = 1;");

        Staf::whereIn('id', [1, 7, 57, 63, 124, 116, 106, 160, 29, 99, 102, 72, 23, 121, 125, 143, 120, 79, 88, 158, 111, 16])->update([
            'aktif' => 1
        ]);

    }
}
