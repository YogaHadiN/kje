<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Tenant;
use App\Models\Staf;
use App\Models\Merek;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $staf = Staf::find(144);
        $staf->owner = 1;
        $staf->save();
    }
}
