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
        $staf = Staf::find(144);
        $staf->owner = 1;
        $staf->save();


        TipeFormula::create([
            'tipe_formula' => 'Cefadroksil capsul 500 mg'
        ]);

        TipeFormula::create([
            'tipe_formula' => 'Cefadroksil syrup 125 mg/5ml'
        ]);

        TipeFormula::create([
            'tipe_formula' => 'Amoxicillin tablet 500 mg'
        ]);

        TipeFormula::create([
            'tipe_formula' => 'Amoxicillin syrup 125 mg/5ml'
        ]);

        TipeFormula::create([
            'tipe_formula' => 'Thiamfenicol capsul 500 mg'
        ]);

        TipeFormula::create([
            'tipe_formula' => 'Thiamfenicol syrup 125 mg/5ml'
        ]);

        TipeFormula::create([
            'tipe_formula' => 'Cefixime capsul 100 mg'
        ]);

        TipeFormula::create([
            'tipe_formula' => 'Cefixime syrup 100 mg/5ml'
        ]);

        TipeFormula::create([
            'tipe_formula' => 'Lainnya'
        ]);

        $tipe_jenis_tarif = TipeJenisTarif::create([
            'tipe_jenis_tarif' => 'BHP'
        ]);


        JenisTarif::where('jenis_tarif', 'BHP')->update([
            'tipe_jenis_tarif_id' => $tipe_jenis_tarif->id
        ]);

        DB::statement("UPDATE formulas frm JOIN komposisis kom ON frm.id = kom.formula_id SET frm.tipe_formula_id = 1 where kom.generik_id = 179 and kom.bobot like '%500%' and (frm.sediaan_id = 3 or frm.sediaan_id = 13);");

        DB::statement("UPDATE formulas frm JOIN komposisis kom ON frm.id = kom.formula_id SET frm.tipe_formula_id = 2 where kom.generik_id = 179 and kom.bobot like '%125%' and (frm.sediaan_id = 5 or frm.sediaan_id = 12);");

        DB::statement("UPDATE formulas frm JOIN komposisis kom ON frm.id = kom.formula_id SET frm.tipe_formula_id = 3 where kom.generik_id = 53 and kom.bobot like '%500%' and (frm.sediaan_id = 3 or frm.sediaan_id = 13);");

        DB::statement("UPDATE formulas frm JOIN komposisis kom ON frm.id = kom.formula_id SET frm.tipe_formula_id = 4 where kom.generik_id = 53 and kom.bobot like '%125%' and (frm.sediaan_id = 5 or frm.sediaan_id = 12);");

        DB::statement("UPDATE formulas frm JOIN komposisis kom ON frm.id = kom.formula_id SET frm.tipe_formula_id = 5 where kom.generik_id = 1123 and kom.bobot like '%500%' and (frm.sediaan_id = 3 or frm.sediaan_id = 13);");

        DB::statement("UPDATE formulas frm JOIN komposisis kom ON frm.id = kom.formula_id SET frm.tipe_formula_id = 6 where kom.generik_id = 1123 and kom.bobot like '%125%' and (frm.sediaan_id = 5 or frm.sediaan_id = 12);");

        DB::statement("UPDATE formulas frm JOIN komposisis kom ON frm.id = kom.formula_id SET frm.tipe_formula_id = 7 where kom.generik_id = 189 and kom.bobot like '%100%' and (frm.sediaan_id = 3 or frm.sediaan_id = 13);");

        DB::statement("UPDATE formulas frm JOIN komposisis kom ON frm.id = kom.formula_id SET frm.tipe_formula_id = 8 where kom.generik_id = 189 and kom.bobot like '%100%' and (frm.sediaan_id = 5 or frm.sediaan_id = 12);");
    }
}
