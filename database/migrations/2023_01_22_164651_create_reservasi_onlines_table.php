<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasiOnlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservasi_onlines', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->string('nomor_asuransi_bpjs')->nullable();
            $table->string('no_telp');
            $table->date('tanggal_lahir')->nullable();
            $table->longText('alamat')->nullable();
            $table->integer('registrasi_pembayaran_id')->nullable();
            $table->integer('register_previously_saved_patient')->nullable();
            $table->integer('pasien_id')->nullable();
            $table->bigInteger('tenant_id')->index();
            $table->string('nomor_bpjs')->nullable();
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
        Schema::dropIfExists('reservasi_onlines');
    }
}
