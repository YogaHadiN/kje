<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeadaanGigisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keadaan_gigis', function (Blueprint $table) {
            $table->id();
            $table->integer('odontogram_id');
            $table->integer('odontogram_abbreviation_id');
            $table->integer('permukaan_gigi_id');
            $table->tinyInteger('matur');
            $table->bigInteger('tenant_id')->index();
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
        Schema::dropIfExists('keadaan_gigis');
    }
}
