<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Tenant;
use App\Models\KategoriCekList;
use App\Models\FrekuensiCek;
use App\Models\Staf;
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
use App\Models\WhatsappBotService;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        WhatsappBotService::create([
            'whatsapp_bot_service' => 'Cek List Harian'
        ]);

        WhatsappBotService::create([
            'whatsapp_bot_service' => 'Input Cek List Harian'
        ]);
    }
}

