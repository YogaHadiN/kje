<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Asuransi;
use App\Models\Staf;
use App\Http\Controllers\BayarGajiController;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $query  = "SELECT ";
        $query .= "DATE_FORMAT(byg.tanggal_dibayar, '%Y-%M') as periode, ";
        $query .= "stf.nama as nama, ";
        $query .= "stf.id as staf_id, ";
        $query .= "sum(byg.gaji_pokok + byg.bonus) as gaji_bruto, ";
        $query .= "sum(pph.pph21) as pph21 ";
        $query .= "FROM bayar_gajis as byg ";
        $query .= "JOIN pph21s as pph on pph.pph21able_id = byg.id and pph21able_type = 'App\\\Models\\\BayarGaji' ";
        $query .= "JOIN stafs as stf on stf.id = byg.staf_id ";
        $query .= "WHERE byg.tanggal_dibayar like '2022%' ";
        $query .= "GROUP BY byg.staf_id, YEAR(byg.tanggal_dibayar), MONTH(byg.tanggal_dibayar);
 ";
        $data = DB::select($query);
        $result = [];
        $by = new BayarGajiController;
        foreach ($data as $d) {
            $by->staf = Staf::find( $d->staf_id );
            $pph_riil = $by->pph21($d->gaji_bruto, 0, 4500000);
            if ( round($pph_riil['pph21']) < $d->pph21 ) {
                $result[] = [
                    'periode'    => $d->periode,
                    'nama'       => $d->nama,
                    'gaji_bruto' => $d->gaji_bruto,
                    'pph21'      => $d->pph21,
                    'pph21_baru' => round($pph_riil['pph21'])
                ];
            }
        }
        dd( $result );
    }
}

