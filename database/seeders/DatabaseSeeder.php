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

        $query  = "select TABLE_NAME from INFORMATION_SCHEMA.COLUMNS where COLUMN_NAME like 'merek_id' order by TABLE_NAME";
        $count = 0;
        foreach (DB::select($query) as $table) {
            $q ='update ' . $table->TABLE_NAME . ' set merek_id = 34 where merek_id in (622, 2226)';
            DB::statement($q);
            Merek::destroy([622,2226]);
        }

    }
}
