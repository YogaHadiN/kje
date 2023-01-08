<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTindakanGigiToJenisTarifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jenis_tarifs', function (Blueprint $table) {
            $table->tinyInteger('tindakan_gigi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jenis_tarifs', function (Blueprint $table) {
            $table->dropColumn('tindakan_gigi');
        });
    }
}
