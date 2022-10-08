<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Tarif;
use App\Models\Asuransi;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $tarif_biaya_pribadis = Tarif::where('asuransi_id', 0)->get();

        Asuransi::where('id', 3)->update([
            'tarif_tersendiri' => 0
        ]);

        foreach ($tarif_biaya_pribadis as $tarif) {
            DB::statement("
                update tarifs trf 
                    join asuransis as asu on asu.id = trf.asuransi_id 
                    set trf.biaya = {$tarif->biaya},
                    trf.jasa_dokter = {$tarif->jasa_dokter}
                    where biaya > 0 
                    and asu.tarif_tersendiri not like 1
                    and trf.jenis_tarif_id = {$tarif->jenis_tarif_id}
            ");
        }
    }
}
