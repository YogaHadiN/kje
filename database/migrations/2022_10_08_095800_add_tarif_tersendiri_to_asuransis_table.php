<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTarifTersendiriToAsuransisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asuransis', function (Blueprint $table) {
            $table->tinyInteger('tarif_tersendiri')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asuransis', function (Blueprint $table) {
            $table->dropColumn('tarif_tersendiri');
        });
    }
}
