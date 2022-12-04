<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCekHarianEmergencyKitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cek_harian_emergency_kits', function (Blueprint $table) {
            $table->id();
            $table->integer('jumlah_gudel_anak');
            $table->string('jumlah_gudel_anak_image');
            $table->integer('jumlah_gudel_dewasa');
            $table->string('jumlah_gudel_dewasa_image');
            $table->integer('jumlah_infus_set');
            $table->string('jumlah_infus_set_image');
            $table->integer('jumlah_nacl');
            $table->string('jumlah_nacl_image');
            $table->integer('jumlah_tiang_Infus');
            $table->string('jumlah_tiang_Infus_image');
            $table->integer('staf_id');
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
        Schema::dropIfExists('cek_harian_emergency_kits');
    }
}
