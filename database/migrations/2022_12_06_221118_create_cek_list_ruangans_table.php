<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCekListRuangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cek_list_ruangans', function (Blueprint $table) {
            $table->id();
            $table->integer('ruangan_id');
            $table->integer('cek_list_id');
            $table->integer('limit_id');
            $table->integer('frekuensi_cek_id');
            $table->integer('jumlah_normal');
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
        Schema::dropIfExists('cek_list_ruangans');
    }
}
