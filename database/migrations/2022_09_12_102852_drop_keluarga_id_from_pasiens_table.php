<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropKeluargaIdFromPasiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pasiens', function (Blueprint $table) {
            $table->dropColumn('keluarga_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pasiens', function (Blueprint $table) {
            $table->integer('keluarga_id');
        });
    }
}
