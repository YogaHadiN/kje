<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Tenant;
use App\Models\KategoriCekList;
use App\Models\FrekuensiCek;
use App\Models\Coa;
use App\Models\Limit;
use App\Models\JurnalUmum;
use App\Models\JenisTarif;
use App\Models\CekList;
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
        FrekuensiCek::create([
            'frekuensi_cek' => 'harian'
        ]);
        FrekuensiCek::create([
            'frekuensi_cek' => 'mingguan'
        ]);
        FrekuensiCek::create([
            'frekuensi_cek' => 'bulanan'
        ]);
        FrekuensiCek::create([
            'frekuensi_cek' => 'tahunan'
        ]);

        CekList::create([
            'cek_list'             => 'jumlah epinefrin inj',
        ]);
        CekList::create([
            'cek_list'             => 'jumlah dexamethasone inj',
        ]);
        CekList::create([
            'cek_list'             => 'jumlah ranitidine inj',
        ]);
        CekList::create([
            'cek_list'             => 'jumlah diphenhydramine inj',
        ]);
        CekList::create([
            'cek_list'             => 'jumlah spuit 3cc',
        ]);
        CekList::create([
            'cek_list'             => 'suhu',
        ]);
        CekList::create([
            'cek_list'             => 'oksigen bisa digunakan',
        ]);
        CekList::create([
            'cek_list'             => 'jumlah gudel',
        ]);
        CekList::create([
            'cek_list'             => 'jumlah_infus_set',
        ]);
        CekList::create([
            'cek_list'             => 'jumlah_nacl',
        ]);
        CekList::create([
            'cek_list'             => 'jumlah_tiang_Infus',
        ]);

        Limit::create([
            'limit' => 'minimal'
        ]);

        Limit::create([
            'limit' => 'maksimal'
        ]);

        Limit::create([
            'limit' => 'sama dengan'
        ]);
    }
}
