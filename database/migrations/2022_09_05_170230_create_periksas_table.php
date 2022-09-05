<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriksasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periksas', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->date('tanggal')->index();
            $table->integer('asuransi_id')->nullable()->index();
            $table->bigInteger('pasien_id')->nullable()->index();
            $table->bigInteger('staf_id')->nullable()->index();
            $table->longText('anamnesa');
            $table->string('pemeriksaan_fisik');
            $table->string('pemeriksaan_penunjang');
            $table->bigInteger('diagnosa_id')->nullable()->index();
            $table->string('keterangan_diagnosa');
            $table->longText('terapi')->nullable();
            $table->integer('piutang')->nullable();
            $table->integer('tunai')->nullable();
            $table->bigInteger('poli_id')->nullable()->index();
            $table->time('jam');
            $table->time('jam_resep');
            $table->longText('transaksi')->nullable();
            $table->integer('berat_badan')->nullable();
            $table->integer('approve_id')->default(0);
            $table->integer('satisfaction_index')->nullable();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->integer('piutang_dibayar')->nullable()->default(0);
            $table->bigInteger('asisten_id')->nullable()->index();
            $table->longText('periksa_awal')->nullable();
            $table->time('jam_periksa')->nullable();
            $table->time('jam_terima_obat')->nullable();
            $table->time('jam_selesai_periksa')->nullable();
            $table->integer('kecelakaan_kerja')->nullable()->default(0);
            $table->string('keterangan')->nullable();
            $table->longText('resepluar')->nullable();
            $table->integer('pembayaran')->nullable();
            $table->integer('kembalian')->nullable();
            $table->string('nomor_asuransi')->nullable();
            $table->integer('antrian_periksa_id')->nullable()->index();
            $table->integer('sistolik')->nullable();
            $table->integer('diastolik')->nullable();
            $table->bigInteger('old_asuransi_id')->nullable()->index();
            $table->boolean('prolanis_dm')->default(false)->index();
            $table->boolean('prolanis_ht')->default(false)->index();
            $table->bigInteger('antrian_id')->nullable()->index();
            $table->bigInteger('invoice_id')->nullable()->index();
            $table->bigInteger('tenant_id')->index();
            $table->string('old_id')->nullable()->index();
            $table->integer('hamil')->nullable()->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('periksas');
    }
}
