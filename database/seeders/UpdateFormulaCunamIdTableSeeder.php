<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Formula;

class UpdateFormulaCunamIdTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Formula::whereIn('sediaan_id', [3, 4, 5	,12, 13])->update([
            'cunam_id' => 2
        ]);
        Formula::whereNotIn('sediaan_id', [3, 4, 5	,12, 13])->update([
            'cunam_id' => 4
        ]);

        DB::statement("update formulas set cunam_id = 3 where id = 132;");
        DB::statement("update formulas set cunam_id = 3 where id = 45;");
        DB::statement("update formulas set cunam_id = 3 where id = 44;");
        DB::statement("update formulas set cunam_id = 3 where id = 1086;");
        DB::statement("update formulas set cunam_id = 3 where id = 1087;");
        DB::statement("update formulas set cunam_id = 3 where id = 1174;");
        DB::statement("update formulas set cunam_id = 1 where id in (15, 16, 75, 173, 1057, 1058, 1117, 1215,14, 117, 1056, 1159, 74);");




	
    }
}
