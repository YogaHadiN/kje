<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasiens', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('nama');
            $table->string('nama_peserta')->nullable();
            $table->string('nomor_asuransi')->nullable();
            $table->string('asuransi_id');
            $table->integer('jenis_peserta_id')->nullable();
            $table->string('sex');
            $table->mediumText('alamat')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('nama_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->text('riwayat_kehamilan_sebelumnya')->nullable();
            $table->text('image')->nullable();
            $table->string('ktp_image')->nullable();
            $table->string('bpjs_image')->nullable();
            $table->string('nomor_asuransi_bpjs')->nullable();
            $table->string('nomor_ktp')->nullable();
            $table->integer('jangan_disms')->nullable()->default(0);
            $table->boolean('sudah_kontak_bulan_ini')->default(false);
            $table->string('kepala_keluarga_id')->nullable();
            $table->boolean('prolanis_ht')->default(false);
            $table->boolean('prolanis_dm')->default(false);
            $table->string('prolanis_ht_flagging_image')->nullable();
            $table->string('prolanis_dm_flagging_image')->nullable();
            $table->string('kartu_asuransi_image')->nullable();
            $table->integer('verifikasi_prolanis_dm_id')->default(1);
            $table->integer('verifikasi_prolanis_ht_id')->default(1);
            $table->integer('meninggal')->default(0);
            $table->integer('penangguhan_pembayaran_bpjs')->default(0);
            $table->bigInteger('tenant_id')->index();
            $table->string('old_id')->index()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pasiens');
    }
}
