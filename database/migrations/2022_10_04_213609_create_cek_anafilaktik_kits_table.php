<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCekAnafilaktikKitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cek_anafilaktik_kits', function (Blueprint $table) {
            $table->id();
            $table->string('ruangan_id');
            $table->integer('staf_id');
            $table->date('tanggal_cek');
            $table->string('anafilactic_kit_image');
            $table->integer('jumlah_epinefrin');
            $table->date('kadaluarsa_epinefrin');
            $table->integer('jumlah_dexa');
            $table->date('kadaluarsa_dexa');
            $table->integer('jumlah_difenhidramin');
            $table->date('kadaluarsa_difenhidramin');
            $table->integer('jumlah_spuit_3cc');
            $table->date('kadaluarsa_spuit_3cc');
            $table->integer('jumlah_needle_27');
            $table->date('kadaluarsa_needle_27');
            $table->integer('jumlah_needle_23');
            $table->date('kadaluarsa_needle_23');
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
        Schema::dropIfExists('cek_anafilaktik_kits');
    }
}
