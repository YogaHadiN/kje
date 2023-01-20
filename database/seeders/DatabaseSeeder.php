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
use App\Models\Document;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        WhatsappBotService::create([
            'whatsapp_bot_service' => 'Registrasi Cek List Bulanan'
        ]);
        WhatsappBotService::create([
            'whatsapp_bot_service' => 'Input Cek List Bulanan'
        ]);
        WhatsappBotService::create([
            'whatsapp_bot_service' => 'Registrasi Konstulasi Estetik Online'
        ]);
        Document::create([
            'nama' => 'PERMENKES NO 3 TAHUN 2023 TTG STANDAR TARIF PELAYANAN KESEHATAN DALAM PENYELENGGARAAN JAMINAN KESEHATAN',
            'tanggal' => date('Y-m-d'),
            'url' => 'upload/dokumen_penting/PERMENKES-NO-3-TAHUN-2023-TTG-STANDAR-TARIF-PELAYANAN-KESEHATAN-DALAM-PENYELENGGARAAN-JAMINAN-KESEHATAN-1 (1).pdf',
            'expiry_date' => null,
            'tenant_id' =>1
        ]);
    }
}

