<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegisteringConfirmationColumnToKonsultasiEstetikOnlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('konsultasi_estetik_onlines', function (Blueprint $table) {
            $table->tinyInteger('registering_confirmation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('konsultasi_estetik_onlines', function (Blueprint $table) {
            $table->dropColumn('registering_confirmation');
        });
    }
}
