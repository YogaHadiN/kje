<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmergencyKitAvailableToRuangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ruangans', function (Blueprint $table) {
            $table->tinyInteger('emergency_kit_available')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ruangans', function (Blueprint $table) {
            $table->dropColumn('emergency_kit_available');
        });
    }
}
