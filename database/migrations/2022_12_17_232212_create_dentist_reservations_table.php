<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDentistReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dentist_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('no_telp');
            $table->integer('registrasi_pembayaran_id');
            $table->date('tanggal_booking');
            $table->string('nama');
            $table->date('tanggal_lahir');
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
        Schema::dropIfExists('dentist_reservations');
    }
}
