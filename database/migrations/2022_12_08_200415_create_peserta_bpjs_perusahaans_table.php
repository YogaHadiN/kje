<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesertaBpjsPerusahaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peserta_bpjs_perusahaans', function (Blueprint $table) {
            $table->id();
            $table->integer('perusahaan_id');
            $table->string('nama');
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
        Schema::dropIfExists('peserta_bpjs_perusahaans');
    }
}
