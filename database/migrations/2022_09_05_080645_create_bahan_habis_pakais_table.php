<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBahanHabisPakaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bahan_habis_pakais', function (Blueprint $table) {
            $table->bigInteger('merek_id')->nullable()->index('merek_id_2');
            $table->integer('jumlah');
            $table->bigInteger('jenis_tarif_id')->nullable()->index('jenis_tarif_id');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->integer('id', true);
            $table->bigInteger('tenant_id')->index();

            $table->index(['merek_id'], 'merek_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bahan_habis_pakais');
    }
}
