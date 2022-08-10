<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetorTunaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setor_tunais', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->bigInteger('staf_id')->index();
            $table->bigInteger('coa_id')->index();
            $table->integer('nominal');
            $table->string('nota_image')->nullable();
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
        Schema::dropIfExists('setor_tunais');
    }
}
