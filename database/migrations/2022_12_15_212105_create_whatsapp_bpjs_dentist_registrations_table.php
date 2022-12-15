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
            $table->integer('asuransi_id');
            $table->integer('previously_registered_pasien_id');
            $table->string('nama');
            $table->string('tanggal_lahir');
            $table->string('nomor_asuransi_bpjs');
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
