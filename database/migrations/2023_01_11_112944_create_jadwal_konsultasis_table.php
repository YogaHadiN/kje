<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalKonsultasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_konsultasis', function (Blueprint $table) {
            $table->id();
            $table->integer('staf_id');
            $table->integer('hari_id');
            $table->time('jam_mulai');
            $table->time('jam_akhir');
            $table->integer('tipe_konsultasi_id');
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
        Schema::dropIfExists('jadwal_konsultasis');
    }
}
