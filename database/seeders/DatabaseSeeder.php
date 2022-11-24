<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Tenant;
use App\Models\Coa;
use App\Models\JurnalUmum;
use App\Models\JenisTarif;
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
        $query  = "select *, jtf.id as jenis_tarif_id from jenis_tarifs as jtf join coas as coa on jtf.coa_id = coa.id where jtf.tenant_id = 2 and coa.tenant_id = 1;";
        $data = DB::select($query);

        foreach ($data as $d) {
            $coa_id_lama         = $d->coa_id;
            $coa_lama            = Coa::find($coa_id_lama);
            $kode_coa            = $coa_lama->kode_coa;
            $coa_baru            = Coa::where('kode_coa', $kode_coa)->where('tenant_id', 2)->first();
            $jenis_tarif         = JenisTarif::find($d->jenis_tarif_id);
            $jenis_tarif->coa_id = $coa_baru->id;
            $jenis_tarif->save();
        }
        $query  = "select *, jur.id as jurnal_umum_id from jurnal_umums as jur join coas as coa on coa.id = jur.coa_id where jur.tenant_id = 2 and coa.tenant_id = 1;";
        $data = DB::select($query);

        foreach ($data as $d) {
            $coa_id_lama         = $d->coa_id;
            $coa_lama            = Coa::find($coa_id_lama);
            $kode_coa            = $coa_lama->kode_coa;
            $coa_baru            = Coa::where('kode_coa', $kode_coa)->where('tenant_id', 2)->first();
            $jenis_tarif         = JurnalUmum::find($d->jurnal_umum_id);
            $jenis_tarif->coa_id = $coa_baru->id;
            $jenis_tarif->save();
        }
    }
}
