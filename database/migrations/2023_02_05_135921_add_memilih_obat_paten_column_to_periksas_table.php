<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMemilihObatPatenColumnToPeriksasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('periksas', function (Blueprint $table) {
            $table->tinyInteger('memilih_obat_paten')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('periksas', function (Blueprint $table) {
            $table->dropColumn('memilih_obat_paten');
        });
    }
}
