<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisterHamilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_hamils', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pasien_id')->nullable();
            $table->string('nama_suami')->nullable();
            $table->integer('tb')->nullable();
            $table->integer('buku_id')->nullable();
            $table->string('golongan_darah')->nullable();
            $table->integer('tinggi_badan')->nullable();
            $table->date('tanggal_lahir_anak_terakhir')->nullable();
            $table->integer('bb_sebelum_hamil')->nullable();
            $table->integer('g')->nullable();
            $table->integer('p')->nullable();
            $table->integer('a')->nullable();
            $table->integer('status_imunisasi_tt_id')->nullable();
            $table->text('riwayat_persalinan_sebelumnya')->nullable();
            $table->integer('jumlah_janin')->nullable();
            $table->date('hpht')->nullable();
            $table->string('rencana_penolong')->nullable();
            $table->string('rencana_tempat')->nullable();
            $table->string('rencana_pendamping')->nullable();
            $table->string('rencana_transportasi')->nullable();
            $table->string('rencana_pendonor')->nullable();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->bigInteger('tenant_id')->index('tenant_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('register_hamils');
    }
}
