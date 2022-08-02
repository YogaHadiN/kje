<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengantarPasiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengantar_pasiens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pengantar_id');
            $table->string('antarable_id')->index();
            $table->string('antarable_type')->index();
            $table->string('kunjungan_sehat');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->integer('pcare_submit')->default(0);
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
        Schema::dropIfExists('pengantar_pasiens');
    }
}
