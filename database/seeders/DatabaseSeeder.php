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
    public function run()
    {
        DB::update("update whatsapp_complaints set tenant_id = 1;");
        DB::update("update recovery_index set tenant_id = 1;");
        DB::update("update failed_therapies set tenant_id = 1;");
        DB::update("update whatsapp_cek_list_harians set tenant_id = 1;");
        DB::update("update cek_list_harians set tenant_id = 1;");
        DB::update("update cek_list_ruangans set tenant_id = 1;");
        DB::update("update perusahaans set tenant_id = 1;");
        DB::update("update peserta_bpjs_perusahaans set tenant_id = 1;");
        DB::update("update whatsapp_satisfaction_surveys set tenant_id = 1;");
        DB::update("update whatsapp_recovery_indices set tenant_id = 1;");
        DB::update("update kuesioner_menunggu_obats set tenant_id = 1;");
        DB::update("update whatsapp_main_menus set tenant_id = 1;");
        DB::update("update whatsapp_bpjs_dentist_registrations set tenant_id = 1;");
        DB::update("update dentist_reservations set tenant_id = 1;");
    }
}
