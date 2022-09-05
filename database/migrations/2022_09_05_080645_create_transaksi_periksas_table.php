<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiPeriksasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_periksas', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('periksa_id')->nullable()->index('periksa_id');
            $table->bigInteger('jenis_tarif_id')->nullable()->index('jenis_tarif_id');
            $table->integer('biaya');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('asisten_tindakan_id')->nullable()->index('asisten_tindakan_id');
            $table->string('keterangan_pemeriksaan')->nullable();
            $table->bigInteger('tenant_id')->index('tenant_id');

            $table->index(['jenis_tarif_id'], 'index_jenis_tarif_id');
            $table->index(['periksa_id'], 'index_periksa_id');
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
        Schema::dropIfExists('transaksi_periksas');
    }
}
