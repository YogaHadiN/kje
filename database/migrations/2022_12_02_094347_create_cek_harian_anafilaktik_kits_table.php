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
            $table->string('jumlah_epinefrin_inj_image');
            $table->integer('jumlah_dexamethasone_inj');
            $table->string('jumlah_dexamethasone_inj_image');
            $table->integer('jumlah_ranitidine_inj');
            $table->string('jumlah_ranitidine_inj_image');
            $table->integer('jumlah_diphenhydramine_inj');
            $table->string('jumlah_diphenhydramine_inj_image');
            $table->integer('jumlah_spuit_3cc');
            $table->string('jumlah_spuit_3cc_image');
            $table->integer('staf_id');
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
