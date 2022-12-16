<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsappBpjsDentistRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whatsapp_bpjs_dentist_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('no_telp');
            $table->integer('registrasi_pembayaran_id')->nullable();
            $table->date('tanggal_booking')->nullable();
            $table->integer('register_previously_saved_patient')->nullable();
            $table->integer('pasien_id')->nullable();
            $table->string('nama')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nomor_asuransi_bpjs')->nullable();
            $table->tinyInteger('data_konfirmation')->default(0);
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
        Schema::dropIfExists('whatsapp_bpjs_dentist_registrations');
    }
}
