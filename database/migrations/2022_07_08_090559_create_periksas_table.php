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
            $table->date('tanggal')->index('index_tanggal');
            $table->integer('asuransi_id')->nullable()->index('index_asuransi_id');
            $table->string('pasien_id')->index('index_pasien_id');
            $table->string('staf_id');
            $table->longText('anamnesa');
            $table->string('pemeriksaan_fisik');
            $table->string('pemeriksaan_penunjang');
            $table->string('diagnosa_id');
            $table->string('keterangan_diagnosa');
            $table->longText('terapi')->nullable();
            $table->integer('piutang')->nullable();
            $table->integer('tunai')->nullable();
            $table->bigInteger('poli_id')->nullable()->index('poli_id');
            $table->time('jam');
            $table->time('jam_resep');
            $table->longText('transaksi')->nullable();
            $table->integer('berat_badan')->nullable();
            $table->integer('approve_id')->default(0);
            $table->integer('satisfaction_index')->nullable();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->integer('piutang_dibayar')->nullable()->default(0);
            $table->date('tanggal_piutang_dibayar')->nullable();
            $table->string('asisten_id');
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
            $table->integer('antrian_periksa_id')->nullable()->index('index_antrian_periksa_id');
            $table->integer('sistolik')->nullable();
            $table->integer('diastolik')->nullable();
            $table->string('old_asuransi_id')->nullable();
            $table->boolean('prolanis_dm')->default(false)->index('index_prolanis_dm');
            $table->boolean('prolanis_ht')->default(false)->index('index_prolanis_ht');
            $table->string('antrian_id')->nullable();
            $table->string('invoice_id')->nullable()->index('index_invoice_id');
            $table->bigInteger('tenant_id')->index('tenant_id');
            $table->string('old_id')->index('old_id');
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
