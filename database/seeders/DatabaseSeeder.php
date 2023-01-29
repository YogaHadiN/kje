<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\JenisKulit;
use App\Models\WhatsappBotService;
use App\Models\PeriodeKeluhanUtama;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        WhatsappBotService::create([
            'whatsapp_bot_service' => 'input gambar di pemeriksaan'
        ]);
    }
}

