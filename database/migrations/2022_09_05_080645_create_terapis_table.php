<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerapisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terapis', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('merek_id')->nullable()->index('merek_id');
            $table->string('signa');
            $table->string('aturan_minum');
            $table->integer('jumlah');
            $table->integer('harga_beli_satuan');
            $table->integer('harga_jual_satuan');
            $table->bigInteger('periksa_id')->nullable()->index('periksa_id');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('tenant_id')->index('tenant_id');

            $table->index(['periksa_id'], 'index_periksa_id');
            $table->index(['merek_id'], 'merek_id_2');
            $table->index(['periksa_id'], 'periksa_id_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('terapis');
    }
}
