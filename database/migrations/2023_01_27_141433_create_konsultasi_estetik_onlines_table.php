<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKonsultasiEstetikOnlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('konsultasi_estetik_onlines', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->tinyInteger('konfirmasi_sdk')->default(0);
            $table->integer('jenis_antrian_id')->nullable();
            $table->string('no_telp');
            $table->date('tanggal_lahir')->nullable();
            $table->longText('alamat')->nullable();
            $table->integer('whatsapp_bot_id');
            $table->integer('register_previously_saved_patient')->nullable();
            $table->integer('pasien_id')->nullable();
            $table->text('keluhan_utama')->nullable();
            $table->integer('periode_keluhan_utama_id')->nullable();
            $table->text('pengobatan_sebelumnya')->nullable();
            $table->integer('jenis_kulit_id')->nullable();
            $table->bigInteger('tenant_id')->index();
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
        Schema::dropIfExists('konsultasi_estetik_onlines');
    }
}
