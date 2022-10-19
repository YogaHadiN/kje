<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\TipeJenisTarif;
use App\Models\JenisTarif;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $tipe_jenis_tarif = TipeJenisTarif::create([
            'tipe_jenis_tarif' => 'Jasa Dokter'
        ]);
        JenisTarif::where('jenis_tarif',  'Jasa Dokter')->update([
            'tipe_jenis_tarif_id' => $tipe_jenis_tarif->id
        ]);
        $tipe_jenis_tarif = TipeJenisTarif::create([
            'tipe_jenis_tarif' => 'Gula Darah'
        ]);
        JenisTarif::where('jenis_tarif',  'Gula Darah')->update([
            'tipe_jenis_tarif_id' => $tipe_jenis_tarif->id
        ]);
        $tipe_jenis_tarif = TipeJenisTarif::create([
            'tipe_jenis_tarif' => 'Biaya Obat'
        ]);
        JenisTarif::where('jenis_tarif',  'Biaya Obat')->update([
            'tipe_jenis_tarif_id' => $tipe_jenis_tarif->id
        ]);
        $tipe_jenis_tarif = TipeJenisTarif::create([
            'tipe_jenis_tarif' => 'USG'
        ]);
        JenisTarif::where('jenis_tarif',  'USG')->update([
            'tipe_jenis_tarif_id' => $tipe_jenis_tarif->id
        ]);
        $tipe_jenis_tarif = TipeJenisTarif::create([
            'tipe_jenis_tarif' => 'surat keterangan sehat'
        ]);
        JenisTarif::where('jenis_tarif',  'surat keterangan sehat')->update([
            'tipe_jenis_tarif_id' => $tipe_jenis_tarif->id
        ]);
        $tipe_jenis_tarif = TipeJenisTarif::create([
            'tipe_jenis_tarif' => 'kb 1 bulan'
        ]);
        JenisTarif::where('jenis_tarif',  'kb 1 bulan')->update([
            'tipe_jenis_tarif_id' => $tipe_jenis_tarif->id
        ]);
        $tipe_jenis_tarif = TipeJenisTarif::create([
            'tipe_jenis_tarif' => 'kb 3 bulan'
        ]);
        JenisTarif::where('jenis_tarif',  'kb 3 bulan')->update([
            'tipe_jenis_tarif_id' => $tipe_jenis_tarif->id
        ]);
        $tipe_jenis_tarif = TipeJenisTarif::create([
            'tipe_jenis_tarif' => 'Bebas'
        ]);
        JenisTarif::where('jenis_tarif',  'Bebas')->update([
            'tipe_jenis_tarif_id' => $tipe_jenis_tarif->id
        ]);

        JenisTarif::where('id', 603)->update([
            'tipe_jenis_tarif_id' => 1
        ]);
    }
}
