<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Tenant;
use App\Models\KategoriCekList;
use App\Models\FrekuensiCek;
use App\Models\Coa;
use App\Models\Hari;
use App\Models\TipeKonsultasi;
use App\Models\Modal;
use App\Models\Limit;
use App\Models\JurnalUmum;
use App\Models\JenisTarif;
use App\Models\CekList;
use App\Models\RecoveryIndex;
use App\Models\WaktuHadir;
use App\Models\OdontogramAbbreviation;
use App\Models\TaksonomiGigi;
use App\Models\PermukaanGigi;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Hari::truncate();
        Hari::create([
            'hari' => 'senin'
        ]);
        Hari::create([
            'hari' => 'selasa'
        ]);
        Hari::create([
            'hari' => 'rabu'
        ]);
        Hari::create([
            'hari' => 'kamis'
        ]);
        Hari::create([
            'hari' => 'jumat'
        ]);
        Hari::create([
            'hari' => 'sabtu'
        ]);
        Hari::create([
            'hari' => 'minggu'
        ]);
        TipeKonsultasi::create([
            'tipe_konsultasi' => 'dokter'
        ]);
        TipeKonsultasi::create([
            'tipe_konsultasi' => 'dokter gigi'
        ]);
        TipeKonsultasi::create([
            'tipe_konsultasi' => 'bidan'
        ]);
        TipeKonsultasi::create([
            'tipe_konsultasi' => 'usg'
        ]);
    }
}

