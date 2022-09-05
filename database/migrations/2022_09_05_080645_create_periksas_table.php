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
            $table->bigInteger('pasien_id')->nullable()->index('pasien_id');
            $table->bigInteger('staf_id')->nullable()->index('staf_id_2');
            $table->longText('anamnesa');
            $table->string('pemeriksaan_fisik');
            $table->string('pemeriksaan_penunjang');
            $table->bigInteger('diagnosa_id')->nullable()->index('diagnosa_id');
            $table->string('keterangan_diagnosa');
            $table->longText('terapi')->nullable();
            $table->integer('piutang')->nullable();
            $table->integer('tunai')->nullable();
            $table->bigInteger('poli_id')->nullable()->index('poli_id_2');
            $table->time('jam');
            $table->time('jam_resep');
            $table->longText('transaksi')->nullable();
            $table->integer('berat_badan')->nullable();
            $table->integer('approve_id')->default(0);
            $table->integer('satisfaction_index')->nullable();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->integer('piutang_dibayar')->nullable()->default(0);
            $table->bigInteger('asisten_id')->nullable()->index('asisten_id');
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
            $table->bigInteger('old_asuransi_id')->nullable()->index('old_asuransi_id');
            $table->boolean('prolanis_dm')->default(false)->index('index_prolanis_dm');
            $table->boolean('prolanis_ht')->default(false)->index('index_prolanis_ht');
            $table->bigInteger('antrian_id')->nullable()->index('antrian_id');
            $table->bigInteger('invoice_id')->nullable()->index('invoice_id_2');
            $table->bigInteger('tenant_id')->index('tenant_id');
            $table->string('old_id')->index('old_id');
            $table->integer('hamil')->nullable()->default(0);

            $table->index(['invoice_id'], 'index_invoice_id');
            $table->index(['pasien_id'], 'index_pasien_id');
            $table->index(['invoice_id'], 'invoice_id');
            $table->index(['staf_id'], 'staf_id');
            $table->index(['pasien_id'], 'pasien_id_2');
            $table->index(['poli_id'], 'poli_id');
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
