<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Tenant;
use App\Models\Staf;
use App\Models\Merek;
use App\Models\TipeFormula;
use App\Models\JenisTarif;
use App\Models\TipeJenisTarif;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Tenant::where('id', 1)->update([
            'address' => 'Komp. Bumi Jati Elok Blok A I No. 7, Jl. Raya Legok - Parung Panjang km. 3, Malangnengah, Pagedangan, Tangerang, Bante.',
            'address_line1' => 'Komplek Bumi Jati Elok Blok A I No. 7',
            'address_line2' => 'Jl. Raya Legok - Parung Panjang km. 3',
            'address_line3' => 'Malangnengah, Pagedangan, Tangerang, Banten Telp 021 5977529',
        ])
    }
}
