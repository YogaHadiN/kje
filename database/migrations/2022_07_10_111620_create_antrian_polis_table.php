<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntrianPolisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antrian_polis', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('pasien_id');
            $table->string('asuransi_id');
            $table->bigInteger('poli_id')->nullable()->index();
            $table->string('staf_id')->nullable();
            $table->date('tanggal');
            $table->time('jam');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->integer('kecelakaan_kerja')->nullable()->default(0);
            $table->integer('self_register')->nullable();
            $table->integer('bukan_peserta')->nullable()->default(0);
            $table->tinyInteger('submitted')->default(0);
            $table->bigInteger('tenant_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('antrian_polis');
    }
}
