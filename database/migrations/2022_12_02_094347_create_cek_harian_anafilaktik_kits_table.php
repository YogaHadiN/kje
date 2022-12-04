<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCekHarianAnafilaktikKitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cek_harian_anafilaktik_kits', function (Blueprint $table) {
            $table->id();
            $table->integer('jumlah_epinefrin_inj');
            $table->integer('jumlah_dexamethasone_inj');
            $table->integer('jumlah_ranitidine_inj');
            $table->integer('jumlah_diphenhydramine_inj');
            $table->integer('jumlah_spuit_3cc');
            $table->tinyInteger('oksigen_bisa_dipakai');
            $table->integer('jumlah_gudel_anak');
            $table->integer('jumlah_gudel_dewasa');
            $table->integer('jumlah_infus_set');
            $table->integer('jumlah_nacl');
            $table->integer('jumlah_tiang_Infus');
            $table->string('image_anafilaktik_kit_tembok');
            $table->string('image_anafilaktik_kit_box');
            $table->bigInteger('ruangan_id')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cek_harian_anafilaktik_kits');
    }
}
