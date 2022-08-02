<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRujukansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rujukans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('periksa_id')->index();
            $table->integer('tujuan_rujuk_id');
            $table->integer('rumah_sakit_id')->nullable();
            $table->string('complication')->nullable();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->integer('register_hamil_id')->nullable();
            $table->string('image')->nullable();
            $table->string('time')->nullable();
            $table->string('age')->nullable();
            $table->string('comorbidity')->nullable();
            $table->integer('tacc')->nullable();
            $table->integer('diagnosa_id')->nullable();
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
        Schema::dropIfExists('rujukans');
    }
}
